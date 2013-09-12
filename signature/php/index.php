<?php
require_once('paramsin.php');
require_once('utils.php');

$params = $_GET;
$error_msg = $config['error_msg'];

$in = array();//待签名参数
$sign_type = (isset($params['sign_type']) && $params['sign_type'] === 'MD5')?'MD5':'RSA';
$partner_id = isset($params['partner_id'])?$params['partner_id']:"default";
//MD5方式的私钥
$private_key = (isset($params['partner_id']) && isset($config['keys']['partner_id']))?
        $config['keys']['partner_id']:$config['keys']['default'];

foreach($config['paramsin'] as $p){
    if(!array_key_exists($p, $params)){
        $out = array(
            'status' => '400001',
            'message' => $error_msg['400001'],
        );
        if($sign_type === 'MD5'){
            $sign = create_sig($out, $private_key);
        }elseif($sign_type === 'RSA'){
            $sign = pri_sign($out, $partner_id);
        }
        $result = array_merge($out,array(
            'sign_type' => $sign_type,
            'sign' => $sign,
        ));
        echo json_encode($result);
        exit();
    }
    if($p !== 'sign' && $p !== 'sign_type'){
        $in[$p] = $params[$p];
    }
}

$current_sig = $params['sign'];
if($params['sign_type'] === 'MD5'){
    $sign = create_sig($in, $config['keys'][$params['partner_id']]);
    if($current_sig !== $sign){
        $out = array(
            'status' => '400002',
            'message' => $error_msg['400002'],
        );
        $sign = create_sig($out, $private_key);
        $result = array_merge($out,array(
            'sign_type' => $sign_type,
            'sign' => $sign,
        ));
        echo json_encode($result);
        exit();
    }
}else{
    if (!pub_verify($in, $sign, $partner_id)) {
        $out = array(
            'status' => '400002',
            'message' => $error_msg['400002'],
        );
        $sign = pri_sign($out, $partner_id);
        $result = array_merge($out,array(
            'sign_type' => $sign_type,
            'sign' => $sign,
        ));
        echo json_encode($result);
        exit();
    }
}
$return = save_info($params);
if ($return){
    $out = array(
        'status' => '200',
        'message' => 'success',
    );
    if($sign_type === 'MD5'){
        $sign = create_sig($out, $private_key);
    }elseif($sign_type === 'RSA'){
        $sign = pri_sign($out, $partner_id);
    }
    $result = array_merge($out, array(
        'sign_type' => $sign_type,
        'sign' => $sign,
    ));
}
echo json_encode($result);
exit();


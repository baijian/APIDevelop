<?php
//MD5
function create_sig($in, $private_key){
    $in = ksort($in);
    $pair = array();
    foreach($in as $k => $v){
        $pair [] = $k. '=' .$v;
    }
    $str = implode('&', $pair);
    return md5($private_key.$str.$private_key);
}

//RSA
function pri_sign($in, $id){
    $pair = array();
    foreach($in as $k => $v){
        $pair[] = $k. '=' .$v;
    }
    $str = implode('&', $pair);
    $private_key = file_get_contents('../rsa_private_key_'.$id.'.pem');
    $pri_key = openssl_pkey_get_private($private_key);
    openssl_sign($str, $sign, $pri_key);
    return base64_encode($sign);
}

function pub_verify($in, $sign, $id){
    $pair = array();
    foreach($in as $k => $v){
        $pair [] = $k. '=' .$v;
    }
    $str = implode('&', $pair);
    $public_key = file_get_contents('../client_keys/rsa_public_key_'.$id.'.pem');
    $pub_key = openssl_pkey_get_public($public_key);
    $result = (bool)openssl_verify($str, base64_decode($sign), $pub_key);
    return $result;
}

function save_info($info){
    //商户处理通知信息
    //.....
    if(True){
        return True;
    }else {
        return False;
    }
}

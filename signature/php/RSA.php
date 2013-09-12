<?php
//RSA.php
//使用openssl实现非对称加密
class RSA{    
    private $_privKey;        /*** private key*/   
    private $_pubKey;        /*** public key*/   
    private $_keyPath;        /*** the keys saving path*/

    /**
     * the construtor,the param $path is the keys saving path
     */
    public function __construct($path){
        if(empty($path) || !is_dir($path)){
            throw new Exception('Must set the keys save path');
        }

        $this->_keyPath = $path;
    }
    /**
     * create the key pair,save the key to $this->_keyPath
     */
    public function createKey($key_bits=1024,$configPath=null){
        $configargs = array(
                'private_key_bits'=>1024
                );
        if(!empty($config))
        {
            $configargs['config'] = $configPath;
        }
        $r = openssl_pkey_new($configargs);
        openssl_pkey_export($r, $privKey, NULL, $configargs);

        file_put_contents($this->_keyPath.'/priv.key', $privKey);
        $this->_privKey = openssl_pkey_get_public($privKey);

        $rp = openssl_pkey_get_details($r);
        $pubKey = $rp['key'];
        file_put_contents($this->_keyPath.'/pub.key', $pubKey);
        $this->_pubKey = openssl_pkey_get_public($pubKey);
    }

    /**
     * setup the private key
     */
    public function setupPrivKey(){
        if(is_resource($this->_privKey)){
            return true;
        }
        $file = $this->_keyPath.'/priv.key';
        $prk = file_get_contents($file);
        $this->_privKey = openssl_pkey_get_private($prk); //==openssl_get_privatekey 
        return true;
    }

    /**
     * setup the public key
     */
    public function setupPubKey(){
        if(is_resource($this->_pubKey)){
            return true;
        }
        $file = $this->_keyPath.'/pub.key';
        $puk = file_get_contents($file);
        $this->_pubKey = openssl_pkey_get_public($puk); //==openssl_get_publickey 别名
        return true;
    }


    /**
     * encrypt with the private key
     */
    public function privEncrypt($data){
        if(!is_string($data)){
            return null;
        }       
        $this->setupPrivKey();
        $r = openssl_private_encrypt($data, $encrypted, $this->_privKey);
        if($r){
            return base64_encode($encrypted);
        }

        return null;
    }

    /**
     * decrypt with the private key
     */
    public function privDecrypt($encrypted){
        if(!is_string($encrypted)){
            return null;
        }

        $this->setupPrivKey();

        $encrypted = base64_decode($encrypted);

        $r = openssl_private_decrypt($encrypted, $decrypted, $this->_privKey);
        if($r){
            return $decrypted;
        }
        return null;
    }

    /**
     * encrypt with public key
     */
    public function pubEncrypt($data){
        if(!is_string($data)){
            return null;
        }

        $this->setupPubKey();

        $r = openssl_public_encrypt($data, $encrypted, $this->_pubKey);
        if($r){
            return base64_encode($encrypted);
        }
        return null;
    }

    /**
     * decrypt with the public key
     */
    public function pubDecrypt($crypted){
        if(!is_string($crypted)){
            return null;
        }

        $this->setupPubKey();

        $crypted = base64_decode($crypted);

        $r = openssl_public_decrypt($crypted, $decrypted, $this->_pubKey);
        if($r){
            return $decrypted;
        }
        return null;
    }

    /**
     * sign with the private key
     */
    public function privSign($data) {
        if(!is_string($data)){
            return null;
        }       
        $this->setupPrivKey();
        openssl_sign($data, $sign, $this->_privKey);
        if($sign){
            return base64_encode($sign);
        }
        return null;
    }
    /**
     * sign verify with the publick key
     */
    public function pubVerify($data,$sign) {
        if(!is_string($data) || !is_string($sign)){
            return null;
        }
        $this->setupPubKey();
        $result = (bool)openssl_verify($data, base64_decode($sign), $this->_pubKey);
        //openssl_free_key($this->_pubKey);
        return $result;
    }

    public function __destruct(){
        @ fclose($this->_privKey);
        @ fclose($this->_pubKey);
    }
}

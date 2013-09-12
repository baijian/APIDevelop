SignatureMechanism
============

##参与签名的参数

在请求参数的列表中,除去sign,sign_type两个参数外,其他
使用到的参数是要签名的参数

在返回参数列表中,除去sign,sign_type两个参数外,凡是通知
返回回来的参数都是要签名的参数

**生成待签名字符串**

```php
$params = array(
    'p1' => 'v1',
    'p2' => 'v2',
    'p3' => 'v3',
);
$in = ksort($params);
$str = "";
foreach($in as $k => $v){
    $str .= $k."=".$v."&";
}
$str = rtrim($str, '&');
```

对数组里的key按字母顺序排序,后以'&'链接,即得到带签名字符串.

**注意点**
* 1.如果请求参数值中存在特殊字符,那么该值需要做urlencode,
    这样接收方才能收到正确参数值,注意待签名数据还应该是原始
    值,而不是encoding后的值.

##签名

###MD5

MD5签名需要将私钥参与签名,MD5私钥是英文字母和数字组成的32
位字符串.

* 1.请求时签名
    
    拿到请求时的签名字符串后,将MD5私钥拼接在待签名字符串
    前面和后面,形成新的字符串,然后再MD5,得到32位签名结果
    字符串,此值赋值给sign.

* 2.返回结果的验证签名

    当获得结果后的待签名字符串后,需要把私钥拼接在待签名字符串的
    前面和后面,形成新的字符串,然后再MD5,得到的值与返回结果中的sign
    进行验证是否相等.

###RSA

采用RSA签名时,需要私钥公钥一起参与签名,私钥公钥通过openssl生成,
    双方需要交换公钥.

**私钥公钥生成**

生成RSA私钥```openssl genrsa -out rsa_private_key.pem 1024```

生成RSA公钥```openssl rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem```

将RSA私钥转换成PKCS8格式(使用PHP语言不需要此步骤)
```openssl pkcs8 -topk8 -infom PEM -in rsa_private_key.pem -outform PEM -nocrypt```


* 1.请求时签名
    
    得到请求时待签名字符串后,把待签名字符串与私钥放入
    RSA的签名函数中进行签名运算,得到结果.

* 2.返回结果时验证签名
    
    当得到返回结果的待签名字符串后,把待签名字符串和对方公钥
    以及sign的值一同放入RSA签名函数中进行非对称签名运算,
    判断签名是否验证通过.
    
    




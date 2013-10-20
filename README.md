How to Design Pragmatic RESTfull API
=======

[Representational State Transfer](http://en.wikipedia.org/wiki/REST)

An API is a developer's UI.

Nowadays, RESTful API is very popular,it is proposed by Roy T.Fielding,
as we all know *HTTP* is a typical design which using restful style.

Pragmatic RESTful API means maxinmize developer productivity and success 
as the primary design principle.

* [RESTful API](#restful-api)

* [SSL or Sign](#ssl-or-sign)

* [API Doc](#api-doc)

* [API Version](#api-version)

* [Data Compression](#data-compression)

* [Data Encryption](#data-encryption)

* [HTTP Status Codes](#http-status-codes)

* [API-Response](#api-response)

* [JSONP-Support](#jsonp-support)

* [Data-Analysis](#data-analysis)

### RESTful API

RESTfull API的核心概念就是将API抽象成逻辑资源,然后充分利用HTTP的方法对这些资源
进行操作.HTTP协议里主要有*GET* *POST* *PUT* *PATCH* *DELETE*这几个主要方法.
既然是资源,当然就应该是名词而不是动词.几个不同的方法就是操作这个名词的动作.

举个具体一点的例子,首先定义一个资源,用户吧(users),那么对这个用户资源有如下操作:

* GET /users -- 获得用户列表

* GET /users/1 -- 获得某个id是1的用户

* POST /users -- 增加一个用户

* PUT /users/1 -- 更新id是1的用户资源

* PATCH /users/1 -- 修改id是1的用户的部分内容

* DELETE /users/1 -- 删除id是1的用户资源

这样URL显得比较干净清晰.可能会有疑问这里URL里面user资源用复数还是单数好呢,
不需要去纠结,就统一都使用复数吧,实用就行.

如果碰到关联的资源RESTful是如何处理的呢?比如用户有资源books:

* GET /users/1/books -- 获得1用户的书列表

* GET /users/1/books/2 -- 获得1用户的书2

* POST /users/1/books -- 给用户1增加一本书资源

* PUT /users/1/books/2 -- 更新用户1的id为2的书的信息

* PATCH /users/1/books/2 -- 更新用户1的id为2的书的部分信息

* DELETE /users/12/books/2 -- 删除id为12的用户的一本id为2的书

实际上有时会碰到非CRUD之类的操作,比如对Github的gist进行加星操作.
把星抽象成这个资源的一部分的话,这个操作就有点像对一个布尔类型
进行是非操作一样,可以用方法*PATCH*这个资源来实现这种操作.

或者Github的做法是把它理解为子资源,也不失为一个很好的方法:

* PUT /gists/:id/star

* DELETE /gists/:id/star

又或者有时确实没办法将一个操作映射成RESTful结构,比如多资源的搜索,这个
不好将它附到任何一个资源上,在这种情况下,就给**/search** 这样得URL就行了,
尽管它不是名字,没有关系,文档清晰不混淆就行.

### SSL or Sign

Ofcourse SSL is most secure, using SSL can guarante encrypted communications
without complex authentication efforts, you can get away with simple access
tokens instead of having to sign sign each API request.

### API Doc

API docs should be easy to find and publically accessible. The docs should 
show examples of complete request/response cycles. Preferably, the requests
should be portable examples - either links that can be pasted into a browser
or curl examples that can be pasted into a terminal.Once release a public API
you should not modify things without notice.The doc must include any updates of
the API, you may delivered it via changelog and so on.Recently, I use *gollum* to
write my API documents, it is a wiki based on *git*, I think it is good, maybe you
can create your own API doc system based on it.

#### Header
```
X-API-Key: The identification of the client app
X-Signature: The signature of this request
```

#### Response:
HTTP Status Code Represent the result 

```
Status: 200 OK
Status: 201 Created
```

#### Client Errors:
* 1.If sending invalid JSON

    HTTP/1.1 400 Bad Request

    {"msg":"Invalid json"}


### API Version

Academically speaking, your API version info should be in a HTTP header.
However, the version need to be in the URL to ensure broser explorability of 
the resources across versions.

<h3 id="compress">Data Compression</h3>

MessagePack is an efficient binary serialization format. It lets you exchange data
among multiple languages like JSON. But is's faster and smaller. Small integers are
encoded into a single byte, and typical strings require only one extra byte in 
additions to the strings themselves.

**PHP Requirement**

* PHP 5.0 +

$ phpbrew ext install msgpack 0.5.5

or 

$ pecl install msgpack

**Code Example**

```php
<?php
$data = array(
    "a" => 1,
    "b" => 2,
);
$msg = msgpack_pack($data);
$data = msgpack_unpack($msg);
```

### Data Encryption

**DES**

```php
private function encrypt($string, $key) {
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_ECB), MCRYPT_RAND);
    $str = mcrypt_encrypt(MCRYPT_DES, $key, $string, MCRYPT_MODE_ECB, $iv);
    return base64_encode($str);
}
private function decrypt($str, $key) {
    $string = base64_decode($str);
    $cipher = MCRYPT_DES;
    $modes = MCRYPT_MODE_ECB;
    $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher, $modes), MCRYPT_RAND);
    return mcrypt_decrypt($cipher, $key, $string, $modes, $iv);
}
```

### HTTP Status Codes

Since HTTP defines a bunch of meaningful status code, so we can use them to indicate our
API errors.
In general, codes in the 2xx range indicate success, codes in
the 4xx range indicate an error that resulted from the provided
information, and codes in the 5xx range indicate an error with 
servers.

**Some Examples**

* 200 OK -- Response to a successful *GET* *PUT* *PATCH* or *DELETE*.

* 201 Created -- Response to a *POST* that results in a creation.

### API Response

In general, API have two type response, ok or not ok, if response is ok, you HTTP response
code is 2xx, and the response body content is the resources you request for; if response is not
ok, your HTTP response code maybe 4xx or 5xx, remember you should custom your response error
body. It should have a code and some messages or description of the error.

**Ok response body**

Just some request resources.

```json
{
    "data":[
        {"a":"fda","b":"fdas"},
        {"a":"fo","b":"xx"}
    ]
}
```

**Not ok response body**

With some json message in your response body is good.

```json
{
    "code": 123,
    "message": "Validation Failed",
    "errors" : [
        {
            "code":1,
            "field": "name",
            "message": "the begging work is not allowed!"
        },
        {
            "code":2,
            "field": "password",
            "message": "you should input something!"
        }
    ]
}
```

### JSONP-Support

[JSONP](http://en.wikipedia.org/wiki/JSONP) is a communication technique used in Javascript programs.

**json result**

```json
{
    "name": "Foo",
    "id": 1234,
    "age": 22
}
```

**jsonp result**

    functionCall({"name":"Foo","id": 1234, "age": 22});

```javascript
<script type="application/javascript" src="http://api.xxx.com/user/1234?callback=functionCall">
</script>
```

Then you should have registered functionCall function in  your javascript.

### Data-analysis

If you design your api use restfull architecture, you can analysis all data you want from your nginx access log.

For examples:

* Count register user count every day. 

Ofcourse I use `storm` to analysis this requirements.

* ....

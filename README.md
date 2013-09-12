How to Design API
=======

An API is a developer's UI.

Nowadays, RESTful API is very popular,it is proposed by Roy T.Fielding,
as we all know *HTTP* is a typical design which using restful style.

* [RESTful API](#rest)

* [APIDocDemo](#doc)


<h3 id="rest">RESTful API</h3>

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
把星抽象成这个资源的一部分的话,这个操作就有点像对一个布尔值activated
进行是非操作一样,可以用方法*PATCH*这个资源来实现这种操作.

或者Github的做法是把它理解为子资源,也不失为一个很好的方法:

* PUT /gists/:id/star

* DELETE /gists/:id/star

又或者有时确实没办法将一个操作映射成RESTful结构,比如多资源的搜索,这个
不好将它附到任何一个资源上,在这种情况下,就给**/search** 这样得URL就行了,
尽管它不是名字,没有关系,文档清晰不混淆就行.

<h3 id="doc">APIDocDemo</h3>
### Header
```
X-API-Key: The identification of the client app
X-Signature: The signature of this request
```

### Response:
HTTP Status Code Represent the result 

```
Status: 200 OK
Status: 201 Created
```

#### Client Errors:
* 1.If sending invalid JSON

    HTTP/1.1 400 Bad Request

    {"msg":"Invalid json"}



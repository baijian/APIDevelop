How to use this API
=======

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



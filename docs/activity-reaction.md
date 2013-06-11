## 返回近期活动接口

```
POST /activities/:activity_id/reaction/:device_id
```

### Header
```
X-API-Key: The identification of the client app
X-Signature: The signature of this request
```
### Paramaters:
* **activity_id**: 
* **device_id**:
* optional:
    * **like**: if like
        * `0` - dislike 
        * `1` - like
    * **clicked**: 近期时间段
        * `0` - ... default
        * `1` - ... 

#### Example: 

* 设备4325439对活动1234的reaction
>```
>    POST /activities/1234/reaction/4325439
>```
>```json
    {
        "like" : "1",
        "clicked" : "1" 
    }
>```

### Response:
```
Status: 200 OK
```
HTTP Status Code 表示运行结果
```json

```

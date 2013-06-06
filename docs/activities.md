## 返回近期活动接口

```
GET /activities/:city_name
```

### Header
```
X-API-Key: The identification of the client app
X-Signature: The signature of this request
```
### Paramaters:
* **city_name**: 
* optional:
    * **last_id**: 上次请求活动列表id最大值
        * `0` -  default
        * `323` - ...
    * **period**: 近期时间段
        * `30` - 30天(1个月) default
        * `60` - 60天(2个月)

#### Example: 

* 返回近一个月北京的活动列表数据
>```
>    GET /activities/beijing
>```

* 返回id大于323且最近28天的活动列表数据
>```
>    GET /brokers/beijing?last_id=323&period=28
>```

### Response:
```
Status: 200 OK
```
HTTP Status Code 表示运行结果
```json
{
"activities" : [
        {
            "id" : 324,
            "weight" : 92,
            "title":"活动标题",
            "url":"http://www.urbanmonkey.cn/",
            "tags":[
                "人文"
                ],
            "content":"活动内容",
            "source":"来源网站",
            "location":"北京科技馆",
            "start_date":"2013-04-17",
            "start_time":"00:00",
            "end_time":"30:00"
        },
        {
            "id" : 325,
            "weight":92,
            "title":"活动标题2",
            "url":"http://www.urbanmonkey.cn/",
            "tags":[
                "人文"
                ],
            "content":"活动内容",
            "source":"来源网站",
            "location":"北京科技馆",
            "start_date":"2013-04-17",
            "start_time":"00:00",
            "end_time":"30:00"
        }
    ]
}
```

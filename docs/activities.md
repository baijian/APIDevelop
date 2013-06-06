## 返回活动接口

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
    * **last_timestamp**: 上次成功获取活动时间
        * `0` -  default
        * `893423` - ...
    * **page**: 页数
        * `1` - default 页码
        * `2` - ...
    * **page_size**: 单页大小
        * `10` - default
        * `20` - ...

#### Example: 

* 返回北京的活动列表
>```
>    GET /activities/beijing
>```

* 返回time stamp:893423之后的活动列表第二页,单页20
>```
>    GET /brokers/beijing?last_timestamp=893423&page=2&page_size=20
>```

### Response:
```
Status: 200 OK
```
HTTP Status Code 表示运行结果
```json
{
"id" : "12",
"timestamp":"1370521017",
"activities" : [
        {
            "weight":92,
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

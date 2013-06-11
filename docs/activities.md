Activities API
===========

* [List city activities](#list)
* [Add](#add)
* [Reaction](#reaction)

<h3 id="list">List city activities</h3>
```
GET /activities/:city_name
```
#### Parameters:
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
```
>    GET /activities/beijing
```

* 返回id大于323且最近28天的活动列表数据
```
>    GET /activities/beijing?last_id=323&period=28
```

```json
[
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
```

<h3 id="reaction">Reaction</h3>
```
PUT /activities/:activity_id/reaction/:device_id
```

#### Parameters:

* **activity_id**: 活动id
* **device_id**: 设备id

#### Input
* **like**: if like
    * `0` - dislike 
    * `1` - like
* **clicked**: 
    * `0` - ... default
    * `1` - ... 
```json
{
    "like" : "1",
    "clicked" : "1"
}
```

#### Example: 

* 设备4325439对活动1234的reaction

```
>    PUT /activities/1234/reaction/4325439
```

```json
    {
        "like" : "1",
        "clicked" : "1" 
    }
```

<h3 id="add">Add</h3>
```
POST  /activities/:city_name
```
#### Parameters:
* **city_name**: beijing shanghai and so on

#### Input:
* **titile**: activity name
* **url**: activity url

```json
    {
        "" : ""
    }
```

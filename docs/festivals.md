Festivals API
====

* [List festivals](#list)

<h3 id="list">List festivals</h3>
```
GET /festivals
```

#### Parameters:
* optional:
    * **period**: 近期时间段
        * `30` - 30天(1个月) default
        * `60` - 60天(2个月)

#### Example: 

* 返回近一个月节日列表数据
```
>    GET /festivals
```

* 返回近两个月节日列表数据
```
>    GET /festivals?period=60
```

#### Response:
```
Status: 200 OK
```

```json
{
"festivals" : [
        {
            "date" : "2013-06-11",
            "name" : 放假
        },
        {
            "date" : "2013-09-21",
            "weight": "放假"
        }
    ]
}
```

Feedback API
==========

* [Add](#add)

<h3 id="add">Create</h3>
```
POST /feedback
```
#### Input
* **data**: feedback data
* **device_id**: device id

```json
{
    "data" : "good software!",
    "device_id" : "421521"
}
```

#### Response
```
Status: 201 Created
```

#### Example
```
>   curl -i -d '{"data":"good!","device_id":"321431"}' http://api.huodongrili.com/feedback
```



Version API
====

* [New version check](#check)
* [App downlaod](#download)

<h3 id="check">New version check</h3>
```
GET /version/:version_num
```
#### Parameters:
* **version_num**: 版本号

#### Response
```
Status: 200
```
```json
{
    "has_new" : "0",
    "url" : ""
}
```

<h3 id="download">App download</h3>
```
GET /version/download
```

#### Parameters:
* optional:
    * **version_num**: 
        * `<newest version>` - default
        * `` - version_num

#### Example:

* download latest(default) version app
```
>   GET /version/download
```

* download one version app
```
>   GET /version/download?version_num=1.0.0
```

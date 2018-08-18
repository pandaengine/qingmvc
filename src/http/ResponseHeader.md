
```
header("Content-type: text/html; charset=utf-8");
header('Cache-control: private'); //max-age
header('X-Powered-By:qingmvc for php');//安全起见可以注释

//-------------------------------
HTTP/1.1 200 OK
Connection			:Keep-Alive
Content-Type			:text/html; charset=utf-8
Date					:Wed, 04 Feb 2015 14:14:07 GMT
Keep-Alive			:timeout=5, max=90
Server				:Apache
Transfer-Encoding	:chunked
//-------------------------------
```

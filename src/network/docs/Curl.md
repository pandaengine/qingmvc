
# CURLOPT_COOKIE

设定 HTTP 请求中"Cookie: "部分的内容。
多个 cookie 用分号分隔，分号后带一个空格(例如， "fruit=apple; colour=red")。

# CURLOPT_POSTFIELDS

这个参数可以是 urlencoded 后的字符串，类似'para1=val1&para2=val2&...'，
也可以使用一个以字段名为键值，字段数据为值的数组。 如果value是一个数组，
Content-Type头将会被设置成multipart/form-data。


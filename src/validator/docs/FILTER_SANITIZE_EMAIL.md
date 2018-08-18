#定义和用法
FILTER_SANITIZE_EMAIL 过滤器删除字符串中所有非法的 e-mail 字符。
该过滤器允许所有的字符、数字以及 $-_.+!*'{}|^~[]`#%/?@&=。
Name: "email"
ID-number: 517

#例子
<?php
$var="some(one)@exa\\mple.com";

var_dump(filter_var($var, FILTER_SANITIZE_EMAIL));
?>
输出：
string(19) "someone@example.com"
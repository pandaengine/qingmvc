#定义和用法
FILTER_VALIDATE_EMAIL 过滤器把值作为电子邮件地址来验证。
Name: "validate_email"
ID-number: 274
#例子
<?php
$email = "someone@exa mple.com";

if(!filter_var($email, FILTER_VALIDATE_EMAIL))
 {
 echo "E-mail is not valid";
 }
else
 {
 echo "E-mail is valid";
 }
?>
输出：
E-mail is not valid
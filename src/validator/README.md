
# QingMVC 验证器组件

qingmvc validator/filter component. validate/filter form user data
用于验证或过滤表单数据、$_GET等用户输入数据

- http://qingmvc.com
- http://qingcms.com
- http://logo234.com  
- http://mangdian.net  

- 验证过滤器: Validator
- 净化过滤器: Filter

# 简介

- 验证扩展类
- 都使用静态成员函数
- 简单明了的调用

# 案例

```
<?php
use qing\validator\Ip;
use qing\validator\Url;
use qing\validator\filter;
use qing\validator\Email;

$ip = "192.168.0.1";
dump(Ip::validate($ip));
dump(Ip::ipv4($ip));
dump(Ip::ipv6($ip));

$ip = "2001:0db8:85a3:08d3:1319:8a2e:0370:7334";
dump(Ip::validate($ip));
dump(Ip::ipv4($ip));
dump(Ip::ipv6($ip));

//
$url = "http://www.qingmvc.com/path/a/b/c?name=哈哈&age=37&code=<b>'123'</b>";
dump(Url::validate($url));
dump(filter\Url::filter($url));

//
$email='qingmvc\'\'""\\1\23$-_.+!*\'{}|^~[]`#%/?@&=@q\'"q.com';
$email='qingmvc@qq.com';
dump(Email::validate($email));
dump(filter\Email::filter($email));

?>
```

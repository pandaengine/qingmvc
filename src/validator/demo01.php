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

//---

$url="http://www.example.com";
dump(Url::validate($url));
dump(Url::adv($url));
$url = "http://www.example.com?name=哈哈&age=37&code=<b>'123'</b>";
dump(Url::validate($url));
dump(Url::adv($url));
$url = "http://www.example.com/path/a/b/c?name=哈哈&age=37&code=<b>'123'</b>";
$url = "http://www.example.com/path/a/b/c?name=哈哈&age=37&code=2";
dump(Url::validate($url));
dump(Url::adv($url));

//
$email='qingmvc\'\'""\\1\23$-_.+!*\'{}|^~[]`#%/?@&=@q\'"q.com';
$email='qing-mvc-@-qq.com';
dump(Email::validate($email));
dump(filter\Email::filter($email));

?>
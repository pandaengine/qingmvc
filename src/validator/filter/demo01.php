<?php
//url
use qing\validator\filter;

//dump($_GET);

$url = "http://www.example.com/path/a/b/c?name=nnn&age=37&code=2&c=<b>123</b>$-_.+!*'(),{}|\^~[]`\"><#%;/?:@&=";
// 		dump(Url::validate($url));
// 		dump(Url::adv($url));

dump(filter\Url::filter($url));

$url='http://php2016.xyz/passport2018/public/index.php/findpwd/<b>123</b>\'\'""111\abc?<a1>=javascript%3Aalert%28%27hoho%27%29%3B&plugin=plugin_manager:design&pid=1&param=<b>123</b>\'\'""\\12#id=\'\'""111\abc23<b>456</b>';
//$url='http://bookmark.qingdb.pw/index.php/<b>123</b>\'\'""?<a1>=javascript%3Aalert%28%27hoho%27%29%3B&plugin=plugin_manager:design&pid=1&param=<b>123</b>\'\'""\\12#id=123<b>456</b>';
dump($url);
// 		dump(Url::validate($url));
dump(filter\Url::filter($url));
dump(addslashes(filter\Url::filter($url)));


?>
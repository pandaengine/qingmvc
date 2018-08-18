<?php
use qing\router\RouteAlias;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
//#路由别名
$aliasParser=new RouteAlias();

$aliasParser->setMap('login2','login2@index');
$aliasParser->setMap('login3',['login3','index']);

dump($aliasParser->createUrl('','login2','index',['id'=>321]));
exit();
?>
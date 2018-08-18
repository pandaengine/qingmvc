<?php
/**
 * 数据库配置
 */
return
[
	//数据库驱动
	'class'=>'\qing\db\pdo\Connection',
	//数据库类型
	'type'  =>'mysql',
	//服务器地址
	'host'	=>'localhost',
	//数据库名
	'name'	=>'qtests',
	//用户名
	'user'	=>'root',
	//密码
	'pwd'	=>'root',
	//端口
	'port'	=>'3306',
	//数据库编码默认采用utf8
	'charset'=>'utf8',
	//数据库表前缀
	'prefix' =>'pre_'
];
?>
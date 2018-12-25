<?php
/**
 * mysql语法结构
 * 约定：保持和官方文档一致，sql关键字使用大写
 * 
 * @todo select更高级用法 group by/having/distinct/join on
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
$_INSERT='INSERT INTO %TABLE% %KEYS% VALUES %VALUES%';
$_REPLACE='REPLACE INTO %TABLE% %KEYS% VALUES %VALUES%';
return [
	//#查询数据
	'SELECT'		=>'SELECT %FIELDS% FROM %TABLE% %WHERE% %GROUPBY% %HAVING% %ORDERBY% %LIMIT% %LOCK%',
	//#统计操作
	//'COUNT'		=>'SELECT COUNT(*) AS COUNT FROM %TABLE% %WHERE%',
	//#插入数据
	//'INSERT'		=>'INSERT INTO %TABLE% %KEYS% VALUES %VALUES%',
	//#替换数据
	//'REPLACE'		=>'REPLACE INTO %TABLE% %KEYS% VALUES %VALUES%',
	'INSERT'		=>$_INSERT,
	'INSERTS'		=>$_INSERT,
	'REPLACE'		=>$_REPLACE,
	'REPLACES'		=>$_REPLACE,
	//#插入数据，唯一冲突则更新某些字段
	'INSERT_UPDATE'	=>'INSERT INTO %TABLE% %KEYS% VALUES %VALUES% ON DUPLICATE KEY UPDATE %UPDATES%',
	//#删除操作
	'DELETE'		=>'DELETE FROM %TABLE% %WHERE%',
	//#更新操作
	'UPDATE'		=>'UPDATE %TABLE% SET %SET% %WHERE%'
];
?>
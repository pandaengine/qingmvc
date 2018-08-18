<?php
namespace qtests;
/**
 * 一些配置信息
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Conf{
	//危险字符串 
	const evil_str='\'\'""\\--==*&^%$#@! \<>?\/[](){}<b>123<b/>';
	const tableName='pre_tests';
}

define('QTESTS_TABLE'		,'pre_tests');
define('QTESTS_TABLE_MYISAM','pre_tests_myisam');
?>
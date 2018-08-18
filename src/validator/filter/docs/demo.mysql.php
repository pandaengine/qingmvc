<?php
namespace qing\filter\traits;
/**
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
/**
 * mysqli::real_escape_string
 * @param string $value   要过滤的值
 * @param \mysqli $mysqli 需要提供mysqli对象实例
 */
function real_escape_string($value,$mysqli){
	return $mysqli->real_escape_string($value);
}
/**
 * 
 * @param string $value
 * @param string $mysqli
 * @return string
 */
function mysql_real_escape_string($value,$mysqli=null){
	return mysql_real_escape_string($value,$mysqli);
}
/**
 * @param string $value
 */
function mysql_escape_string($value){
	return mysql_escape_string($value);
}
?>
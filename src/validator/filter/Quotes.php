<?php
namespace qing\validator\filter;
/**
 * 引号转义
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Quotes{
	/**
	 * 转义单双引号
	 * 
	 * @param string $value
	 * @return string
	 */
	public static function filter($value){
		return addcslashes($value,'\'"');
	}
	/**
	 * 移除单双引号
	 * 
	 * @param string $value
	 * @return string
	 */
	public static function remove($value){
		return str_replace(['\'','"'],'',$value);
	}
	/**
	 * 转义单引号
	 *
	 * @param string $value
	 * @return string
	 */
	public static function singe($value){
		return addcslashes($value,'\'');
	}
	/**
	 * 转义双引号
	 * 
	 * @param string $value
	 * @return string
	 */
	public static function double($value){
		return addcslashes($value,'"');
	}
}
?>
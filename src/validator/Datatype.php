<?php
namespace qing\validator;
/**
 * 数据类型验证器
 * 
 * @deprecated 简单的验证，直接使用系统函数
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Datatype{
	/**
	 * 验证值是否是布尔值
	 *
	 * @param mixed $value
	 * @return bool
	 */
	public static function is_bool($value){
		return is_bool($value);
	}
	/**
	 * 是否是数组
	 *
	 * @param mixed $value
	 * @return bool
	 */
	public static function is_array($value){
		return is_array($value);
	}
	/**
	 * int|123|不能是字符串'123'
	 *
	 * @param mixed $value
	 * @return bool
	 */
	public static function is_int($value){
		return is_int($value);
	}
	/**
	 * 是否是数值|'123'/123|可以是字符串类型的数值
	 *
	 * @param mixed $value
	 * @return bool
	 */
	public static function is_numeric($value){
		return is_numeric($value);
	}
	/**
	 * @param mixed $value
	 * @return bool
	 */
	public static function is_number($value){
		//return preg_match("/^[0-9]*$/",$value);
		return is_numeric($value);
	}
	/**
	 * 浮点数
	 * 
	 * @param mixed $value
	 * @return boolean
	 */
	public static function is_float($value){
		return is_float($value);
	}
}
?>
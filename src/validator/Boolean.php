<?php
namespace qing\validator;
/**
 * 数据类型验证器
 * 
 * @notice 简单验证器，使用静态函数
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Boolean{
	/**
	 * @param string $value
	 * @return boolean
	 */
	public static function validate($value,array $allowValues=[true,false,'true','false','0','1',0,1]){
		//strict=true:检测数据类型
		return in_array($value,$allowValues,true);
	}
	/**
	 * @param string $value
	 * @return boolean
	 */
	public static function str($value,array $allowValues=['true','false','0','1']){
		return in_array((string)$value,$allowValues,true);
	}
	/**
	 * @param string $value
	 * @return boolean
	 */
	public static function number($value,array $allowValues=[0,1]){
		return in_array((int)$value,$allowValues);
	}
	/**
	 * @param string $value
	 * @return boolean
	 */
	public static function numeric($value,array $allowValues=[0,1,'0','1']){
		//strict=true:检测数据类型
		return in_array($value,(array)$allowValues,true);
	}
}
?>
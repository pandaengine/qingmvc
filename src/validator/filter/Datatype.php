<?php
namespace qing\validator\filter;
/**
 * 数据类型过滤器|整型/布尔型
 * 格式化为某数据类型|强制转换成某数据类型
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Datatype{
	/**
	 * 强制转换成布尔值
	 *
	 * @param string $value
	 * @return boolean
	 */
	public static function boolean($value){
		return $value?true:false;
	}
	/**
	 * 强制转换成布尔值
	 *
	 * @param string $value
	 * @return boolean
	 */
	public static function bool01($value){
		return $value?1:0;
	}
	/**
	 * 强制转换成整型
	 * 返回合法的int型数据
	 * 净化只剩下整型
	 *
	 * @param string $value
	 * @return string 返回字符串
	 */
	public static function numeric($value){
		return is_numeric($value)?$value:'0';
	}
	/**
	 * 清除数字以外的字符|净化只剩下数字
	 *
	 * @param string $value
	 * @return string 返回字符串
	 */
	public static function number($value){
		return preg_replace('/[^0-9]/','',$value);
	}
	/**
	 * 强制转换成整型|返回合法的int型数据|净化只剩下整型
	 *
	 * @param string $value
	 * @return integer
	 */
	public static function int($value){
		return (int)$value;
	}
	
	/**
	 * 强制转换成浮点数|净化只剩下浮点数
	 *
	 * @param string $value
	 * @return number
	 */
	public static function float($value){
		return (float)$value;
	}
	/**
	 * 返回非空字符串|清除空字符
	 * \s:空字符
	 * \S:非空字符
	 *
	 * @param string $value
	 * @return string
	 */
	public static function str($value){
		return preg_replace('/\s/','',$value);
	}
}
?>
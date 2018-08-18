<?php
namespace qing\utils;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Datatype{
	/**
	 * 整型布尔值
	 * int boolean
	 * 
	 * @param array $value
	 * @return string
	 */
	static public function ibool($value){
		return $value?1:0;
	}
	/**
	 * 取得最小值
	 *
	 * @param number $num1
	 * @param number $num2
	 */
	static public function number_min($num1,$num2){
		return $num1<=$num2?$num1:$num2;
	}
	/**
	 * 取得最小值
	 *
	 * @param number $num1
	 * @param number $num2
	 */
	static public function number_max($num1,$num2){
		return $num1>=$num2?$num1:$num2;
	}
}
?>
<?php 
namespace qing\utils;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Str{
	/**
	 * 默认值
	 * 
	 * @param mixed|array|string $var
	 * @param string $defValue
	 * @return string
	 */
	public static function def($var,$defValue=''){
		if(!$var){ 
			return $defValue;
		}else{
			return $var;
		}
	}
	/**
	 * 字符串前缀
	 * 
	 * @param string $var
	 * @param string $prefix
	 * @return string
	 */
	public static function prefix($var,$prefix=''){
		if(!$var){
			return $var;
		}
		return $prefix.$var;
	}
	/**
	 * 字符串变量值后缀
	 *
	 * @param string $var
	 * @param string $suffix
	 * @return string
	 */
	public static function suffix($var,$suffix=''){
		if(!$var){
			return '';
		}
		return $var.$suffix;
	}
	/**
	 * 格式化性别显示
	 *
	 * @param string $gender
	 * @param string $format 格式
	 * @return string
	 */
	public static function gender($gender,$format=['女','男']){
		$gender=(int)$gender;
		if($gender!==0){
			$gender=1;
		}
		return $format[$gender];
	}
	/**
	 * 格式化状态
	 *
	 * @param string $status
	 * @param string $format 格式
	 * @return string
	 */
	public static function status($status,$format=['关闭','开启']){
		if($status){
			$status=1;
		}
		return $format[$status];
	}
	/**
	 * 格式化状态
	 *
	 * @param string $bool
	 * @param string $format 格式
	 * @return string
	 */
	public static function intbool($bool,$format=[0,1]){
		if($bool){
			$key=1;
		}else{
			$key=0;
		}
		return $format[$key];
	}
}
?>
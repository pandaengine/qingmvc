<?php
namespace qing\validator\filter;
/**
 * 转义过滤
 * 转义危险字符，php标签，html标签，sql注入标签
 * 
 * @see addslashes | add slashes |添加转义斜线
 * @see addcslashes Quote string with slashes in a C style
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Escape{
	/**
	 * '_' 单个字符通配符
	 * '%' 多个字符通配符
	 * addcslashes($value,'_%');
	 * 
	 * addslashes:特殊符号转义|在预定义字符之前添加反斜杠
	 * - 单引号（'）
	 * - 双引号（"）
	 * - 反斜线（\）与
	 * - NUL（NULL 字符）。
	 * 
	 * addcslashes:转义指定字符
	 * 
	 * @param string $value
	 * @param string $plus
	 * @return mixed
	 */
	public static function filter($value,$plus=''){
		$value=addslashes($value);
		if($plus){
			$value=addcslashes($value,$plus);
		}
		return $value;
	}
}
?>
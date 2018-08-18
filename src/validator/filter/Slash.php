<?php
namespace qing\validator\filter;
/**
 * 斜杠，这里指反斜杠符号
 * 
 * @name backslash
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Slash{
	/**
	 * 转义反斜杠
	 * 
	 * @param string $value
	 * @return string
	 */
	public static function filter($value){
		return addcslashes($value,'\\');
	}
	/**
	 * 移除反斜杠
	 *
	 * @param string $value
	 * @return string
	 */
	public static function remove($value){
		return str_replace('\\','',$value);
	}
	/**
	 * 添加斜杠
	 * 
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
	 * @return mixed
	 */
	public static function add($value){
		return addslashes($value);
	}
	/**
	 * 在[指定]的字符前添加反斜杠。
	 * ---
	 * 在对 0，r，n 和 t 应用 addcslashes() 时要小心。
	 * 在 PHP 中，\0，\r，\n 和 \t 是预定义的转义序列。
	 * ---
	 *
	 * @name addcslashes Quote string with slashes in a C style | 以 C 语言风格使用反斜线转义字符串中的字符
	 * @param $value
	 * @param $characters "
	 */
	public static function addc($value,$charlist='\'"'){
		return addcslashes($value,$charlist);
	}
	/**
	 * 移除反斜杠
	 * 删除由 addslashes()函数给[预定义]字符添加的反斜杠。
	 * 
	 * @param string $value
	 * @return string
	 */
	public static function strip($value){
		return stripslashes($value);
	}
	/**
	 * 反转义
	 *
	 * @param string $value
	 * @return string
	 */
	public static function stripc($value){
		return stripcslashes($value);
	}
}
?>
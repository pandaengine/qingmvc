<?php
namespace qing\validator\filter;
use qing\validator\Email as EmailVld;
/**
 * 邮箱过滤器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Email{
	/**
	 * 过滤邮箱，安全性高
	 *
	 * @param string $value
	 * @return boolean
	 */
	public static function filter($value){
		return EmailVld::validate($value)?$value:'';
	}
	/**
	 * 过滤邮箱
	 * - 基于php自带函数filter_var
	 * - 安全性不高
	 * 
	 * FILTER_SANITIZE_EMAIL 过滤器删除字符串中所有非法的 e-mail 字符。
	 * 该过滤器允许：所有的字母、数字以及 $-_.+!*'{}|^~[]`#%/?@&=
	 * 
	 * 注意：只是简单的过滤，并不是安全的，仍有特殊符号'"\等，仍可能导致xss，sqlij
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public static function f($value){
		return filter_var($value,FILTER_SANITIZE_EMAIL);
	}
}
?>
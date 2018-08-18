<?php
namespace qing\validator;
/**
 * 自定义正则表达式过滤器
 * 正则表达式|清除匹配
 *
 * @deprecated 直接使用函数
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Regexp{
	/**
	 * 正则表达式
	 * $subject = "abcdef";
	 * $pattern = '/^def/';
	 * array("abcdef","regexp" ,"邮箱格式错误"	,"filter",1,array('/^def/'))
	 * ---------------------------------
	 * @param string $value		要验证的值
	 * @param string $pattern   正则表达式
	 * @param boolean $reverse   反转
	 * @return bool
	 */
	public static function validate($value,$pattern,$reverse=false){
		$res=preg_match($pattern,$value)>0;
		if($reverse){
			return !$res;
		}else{
			return $res;
		}
	}
}
?>
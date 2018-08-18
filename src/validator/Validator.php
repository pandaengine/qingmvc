<?php
namespace qing\validator;
/**
 * filter:净化过滤器
 * validator:验证过滤器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Validator{
	/**
	 * 转义附加规则模式
	 *
	 * @param string $plus
	 * @return string
	 */
	static public function quote($plus){
		if($plus){
			return preg_quote($plus,'/');
		}
		return '';
	}
	/**
	 *
	 * @see Id
	 * @param string $value
	 * @param number $len
	 * @return boolean
	 */
	static public function guid($value,$len=32){
		return preg_match('/^[a-z0-9]{'.$len.'}$/i',$value)>0;
	}
	/**
	 * 时间戳|十位整型
	 *
	 * @param string $value
	 * @return number
	 */
	static public function timestamp($value){
		return preg_match('/^[0-9]{10}$/i',$value)>0;
	}
	/**
	 * 过滤安全文本
	 *
	 * @see Email
	 * @param string $value
	 */
	static public function email($value){
		return Email::validate($value);
	}
	/**
	 *
	 * @see Url
	 * @param string $value
	 * @param string $checkScheme
	 * @return boolean
	 */
	static public function url($value,$checkScheme=true){
		return Url::validate($value,$checkScheme);
	}
	/**
	 * 字符串，字节数
	 * 
	 * @see StrLen
	 */
	static public function charlen($value,$min,$max){
		return StrLen::validate($value,$min,$max);
	}
	/**
	 * 字符串，字符个数
	 *
	 * @see Chars
	 */
	static public function charnum($value,$min,$max,$charset='utf-8'){
		return Chars::validate($value,$min,$max,$charset);
	}
	/**
	 * 
	 * @see SafeChar
	 */
	static public function abc123($value,$plus=''){
		return SafeChar::abc123($value,$plus);
	}
}
?>
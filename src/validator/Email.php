<?php
namespace qing\validator;
/**
 * 邮箱验证器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Email{
	/**
	 * 验证邮箱，较高的安全性
	 * 只允许：字母,数字,@,特殊字符 - _ .
	 * 
	 * qingmvc@qingmvc.com.cn
	 * 用户名@域名
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public static function validate($value){
		$arr=explode('@',$value);
		if(count($arr)!=2){
			return false;
		}
		//验证域名段
		if(!Domain::validate($arr[1])){
			return false;
		}
		//验证用户名段，只允许字母数字减号
		//排除法，匹配到非法字符则失败
		return preg_match('/[^a-zA-Z0-9\-]/',$arr[0])==0;
	}
	/**
	 * 验证邮箱
	 * filter_var($value,FILTER_VALIDATE_EMAIL)
	 * 可以使用#%等
	 * 
	 * 注意：只是简单的验证，并不是安全的，仍有特殊符号'"\等，仍可能导致xss，sqlij
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public static function v($value){
		return filter_var($value,FILTER_VALIDATE_EMAIL)!==false;
	}
}
?>
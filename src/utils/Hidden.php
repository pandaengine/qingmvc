<?php 
namespace qing\utils;
/**
 * 隐藏隐私信息
 * email/username/password
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0 all rights reserved.
 */
class Hidden{
	/**
	 * 只显示第一位和最后一位字符
	 * 
	 * @param string $value
	 * @return string
	 */
	public static function format($value){
		return substr($value,0,1).'***'.substr($value,-1);
	}
	/**
	 * 隐藏用户邮箱的部分
	 *
	 * 736523132@qq.com -> 7****@qq.com
	 * 7@qq.com 		-> 7****@qq.com
	 * ---
	 * \S非空，\s空
	 * 前瞻断言,正面断言： \w+(?=;) 匹配一个单词紧跟着一个分号但是匹配结果不会包含分号，
	 * 后瞻断言,正面断言以"(?<="开始, 消极断言以"(?<!"开始。
	 * (?<!foo)bar 用于查找任何前面不是 ”foo” 的 ”bar”。
	 * (?<=bullock|donkey)bar    查找任何前面是 ”bullock或 donkey ” 的 ”bar”。
	 * ---
	 * 
	 * @param  $email
	 * @return string
	 */
	public static function emailX1($email){
		return preg_replace('/(?<=^\S)(.*)(?=@.*$)/','***',$email);
	}
	/**
	 * @param string $email
	 * @return string
	 */
	public static function email($email){
		list($name,$suffix)=explode('@',$email);
		//#名称去第一位和最后一位
		$name=substr($name,0,1).'***'.substr($name,-1);
		return $name.'@'.$suffix;
	}
}
?>
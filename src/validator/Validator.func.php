<?php 
/**
 * filter:净化过滤器
 * validator:验证过滤器
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
/**
 *
 * @param string $value
 * @return number
 */
function v_guid($value){
	return preg_match('/^[a-z0-9]{32}$/i',$value)>0;
}
/**
 * 时间戳|十位整型
 *
 * @param string $value
 * @return number
 */
function v_timestamp($value){
	return preg_match('/^[0-9]{10}$/i',$value)>0;
}
/**
 * 过滤安全文本
 *
 * @see \qing\validator\Email
 * @param string $value
 */
function v_email($value){
	return \qing\validator\Email::v_email($value);
}
/**
 *
 * @see \qing\validator\Url
 * @param string $value
 * @param string $checkScheme
 * @return boolean
 */
function v_url($value,$checkScheme=true){
	return \qing\validator\Url::v_url($value,$checkScheme);
}
/**
 * 字符个数
 *
 * @see \qing\validator\CharNum
 * @param string $value
 * @param number $min
 * @param number $max
 * @param string $charset
 * @return mixed
 */
function v_charnum($value,$min,$max,$charset='utf-8'){
	return \qing\validator\Chars::validate($value,$min,$max,$charset);
}
/**
 * f_abc123('',['plus'=>'_-']);
 *
 * @see \qing\validator\StringSafe
 * @param string $value
 * @param string $plus
 * @return boolean
 */
function v_abc123($value,$plus=''){
	if($plus){
		$plus=preg_quote($plus,'/');
	}
	$pattern='/^[a-zA-Z0-9'.$plus.']*$/';
	return preg_match($pattern,$value)>0;
}
?>
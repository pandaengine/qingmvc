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
 * 过滤安全文本
 *
 * @see \qing\filter\SafeText
 * @param string $value
 */
function f_safetext($value,$sql=true,$like=false){
	return \qing\filter\SafeText::filter($value,$sql,$like);
}
/**
 * f_abc123('','_-');
 *
 * @see \qing\filter\SafeChar
 * @param string $value
 * @param string $plus
 */
function f_abc123($value,$plus=''){
	return \qing\filter\SafeChar::abc123($value,$plus);
}
/**
 *
 * @see \qing\filter\Sql
 * @param string $value
 * @param string $props
 */
function f_sql($value,$plus=''){
	return \qing\filter\Sql::filter($value,$plus);
}
/**
 *
 * @param string  $value
 * @param boolean $throwErr 默认抛出异常
 * @return string
 */
function f_guid($value,$throwErr=true){
	$value=(string)$value;
	if(!$value || !v_guid($value)){
		//#非guid
		if($throwErr){
			//#抛出异常
			throw new \Exception(L()->vld_guid_invalid);
		}
		$value='';
	}
	return $value;
}
/**
 * 时间戳|十位整型
 *
 * @param string $value
 * @return number
 */
function f_timestamp($value){
	if(!v_timestamp($value)){
		$value=0;
	}
	return $value;
}
?>
<?php
namespace qing\validator\filter;
use qing\validator\Id;
use qing\validator\Validator;
/**
 * filter:净化过滤器
 * validator:验证过滤器
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Filter{
	/**
	 * 转义附加规则
	 *
	 * @param string $plus
	 * @return string
	 */
	public static function quote($plus){
		if($plus){
			//转移
			return preg_quote($plus,'/');
		}
		return '';
	}
	/**
	 * 过滤安全文本
	 *
	 * @see SafeText
	 * @param string $value
	 */
	static public function safetext($value,$sql=true,$like=false){
		return SafeText::filter($value,$sql,$like);
	}
	/**
	 * @see SafeChar
	 * @param string $value
	 * @param string $plus
	 */
	static public function abc123($value,$plus=''){
		return SafeChar::abc123($value,$plus);
	}
	/**
	 *
	 * @see Sql
	 * @param string $value
	 * @param string $like
	 */
	static public function sql($value,$like=false){
		return Sql::filter($value,$like);
	}
	/**
	 *
	 * @param string  $value
	 * @param boolean $throwErr 默认抛出异常
	 * @return string
	 */
	static public function guid($value,$throwErr=true){
		$value=(string)$value;
		if(!$value || !Id::guid($value)){
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
	static public function timestamp($value){
		if(!Validator::timestamp($value)){
			$value=0;
		}
		return $value;
	}
}
?>
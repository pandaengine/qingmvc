<?php
namespace qing\forms;
use qing\validator\filter\SafeText;
use qing\validator\Chars;
/**
 * 表单/表格
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Form{
	/**
	 * 错误信息
	 *
	 * @var string
	 */
	protected $error='';
	/**
	 * 获取模型内部错误信息
	 *
	 * @return string
	 */
	public function getError(){
		return $this->error;
	}
	/**
	 * 设置错误信息
	 *
	 * @return string
	 */
	public function setError($error){
		$this->error=$error;
	}
	/**
	 * @param string $field
	 */
	public function error_required($field){
		$this->field_error($field,L()->vld_required);
	}
	/**
	 * @param string $field
	 */
	public function error_email_invalid($field){
		$this->field_error($field,L()->vld_email_invalid);
	}
	/**
	 * @param string $field
	 */
	public function error_invalid($field){
		$this->field_error($field,L()->vld_invalid);
	}
	/**
	 * @param string $field
	 */
	public function error_string_len_invalid($field){
		$this->field_error($field,L()->vld_string_len_invalid);
	}
	/**
	 * 字段错误
	 * 表单域错误
	 * 
	 * @param string $field
	 * @param string $msg
	 */
	protected function field_error($field,$msg){
		$field>'' && $field.=': ';
		$this->error=$field.$msg;
	}
	/**
	 * 字符个数
	 *
	 * @param string $value
	 * @param number $min
	 * @param number $max
	 * @param string $charset
	 * @return boolean
	 */
	function v_charnum($value,$min,$max,$charset='utf-8'){
		return Chars::validate($value,$min,$charset);
	}
	/**
	 * 过滤安全文本
	 *
	 * @param string $value
	 */
	function f_safetext($value){
		return SafeText::filter($value);
	}
}
?>
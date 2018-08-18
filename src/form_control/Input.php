<?php
namespace qing\form_control;
/**
 * Input标签
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */
class Input extends Control{
	/**
	 * 表单域类型
	 * 
	 * hidden
	 * submit
	 * button
	 * email
	 * reset
	 * 
	 * @var string
	 */
	public $type='text';
	/**
	 * @param string $type
	 * @return $this
	 */
	public function type($type){
		$this->type=$type;
		return $this;
	}
	/**
	 * @see \form_control\Control::render()
	 */
	public function render(){
		$type	  =$this->type;
		$name	  =$this->name;
		$value	  =$this->value;
		$className=$this->className;
		$attr	  =$this->attr;
		
		$tpl ="<input type='{$type}' name='{$name}' value='{$value}' class='{$className}' {$attr} />";
		return $tpl;
	}
}
?>
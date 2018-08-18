<?php
namespace qing\form_control;
/**
 * Checkbox多选按钮标签
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */
class Checkbox extends Input implements ControlInterface{
	/**
	 * 表单域类型
	 *
	 * @var string
	 */
	public $type='checkbox';
	/**
	 * 是否选择
	 *
	 * @var boolean
	 */
	public $checked=false;
	/**
	 * 
	 * @return string
	 */
	public function render(){
		$type	  =$this->type;
		$name	  =$this->name;
		$value	  =$this->value;
		$className=$this->className;
		$attr	  =$this->attr;
		
		$checkedStr='';
		if((bool)$this->checked || (bool)$value){
			$checkedStr=" checked='checked' ";
		}
		$this->attr=$attr.' '.$checkedStr;
		
		return parent::render();
	}
}
?>
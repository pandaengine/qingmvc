<?php
namespace qing\form_control;
/**
 * Textarea标签
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */
class Textarea extends Control implements ControlInterface{
	/**
	 * 类名
	 *
	 * @var string
	 */
	public $className='form-control';
	/**
	 * @see \form_control\Control::render()
	 */
	public function render(){
		$name	  =$this->name;
		$value	  =$this->value;
		$attr	  =$this->attr;
		$className=$this->className;
		
		$tpl="<textarea name='{$name}' class='{$className}' {$attr} >{$value}</textarea>";
		return $tpl;
	}
}
?>
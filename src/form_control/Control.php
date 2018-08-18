<?php
namespace qing\form_control;
/**
 * Control
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */
abstract class Control implements ControlInterface{
	/**
	 * 类名
	 *
	 * @var string
	 */
	public $className='form-control';
	/**
	 * 表单域名称
	 * 
	 * @var string
	 */
	public $name='';
	/**
	 * 表单值
	 *
	 * @var string
	 */
	public $value;
	/**
	 * 附加属性
	 *
	 * @var string
	 */
	public $attr='';
	/**
	 * - 选项
	 * - 可选择数据|[value:title]|[value,title,optionAttr]
	 *
	 * @var string
	 */
	public $options=[];
	/**
	 *
	 * @return string
	 */
	abstract public function render();
	/**
	 * @param array $options
	 * @return $this
	 */
	public function options(array $options){
		$this->options=$options;
		return $this;
	}
	/**
	 * @param string $name
	 * @return $this
	 */
	public function name($name){
		$this->name=$name;
		return $this;
	}
	/**
	 * @param string value
	 * @return $this
	 */
	public function value($value){
		$this->value=$value;
		return $this;
	}
	/**
	 *
	 * @param string $attr
	 * @return $this
	 */
	public function attr($attr){
		$this->attr=$attr;
		return $this;
	}
	/**
	 * 
	 * @param string $className
	 * @return $this
	 */
	public function className($className){
		$this->className=$className;
		return $this;
	}
}
?>
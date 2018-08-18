<?php
namespace qing\form_control;
/**
 * Radio标签
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */
class Radio extends Control implements ControlInterface{
	/**
	 * 表单域类型
	 *
	 * @var string
	 */
	public $type='radio';
	/**
	 * 是否标题
	 *
	 * @var string
	 */
	public $radioTitle=['是','否'];
	/**
	 * 是否值
	 *
	 * @var string
	 */
	public $radioValue=['1','0'];
	/**
	 * 类名
	 *
	 * @var string
	 */
	public $className='';
	/**
	 *
	 * @return string
	 */
	public function render(){
		$type	  =$this->type;
		$name	  =$this->name;
		$value	  =$this->value;
		$attr	  =$this->attr;
		$className=$this->className;
		
		//#选择状态
		$checkedYes='';
		$checkedNo ='';
		//#标题
		list($titleYes,$titleNo)=(array)$this->radioTitle;
		//#值
		list($valueYes,$valueNo)=(array)$this->radioValue;
		
		if($valueYes==$value){
			$checkedYes=' checked="checked" ';
		}
		if($valueNo==$value){
			$checkedNo=' checked="checked" ';
		}
		
		$radio=<<<NOWDOC
<div class="radio">
	<label><input type="{$type}" name="{$name}" value="{$valueYes}" class="{$className}" {$attr}  {$checkedYes}/>{$titleYes}</label>
	<label><input type="{$type}" name="{$name}" value="{$valueNo}"  class="{$className}" {$attr}  {$checkedNo} />{$titleNo}</label>
</div>
NOWDOC;
		return $radio;
	}
}
?>
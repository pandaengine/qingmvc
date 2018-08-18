<?php
namespace qing\form_control;
/**
 * Select表单域
 * 
 * 
 * @property options array
 * - 选项
 * 
 * [ 
 * 	[value=>title]
 * 	[value=>title]
 * ]
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */
class SelectKv extends Control{
	/**
	 * 选择栏
	 * ---
	 * $options=array(
	 * 		"value"=>"title",
	 * 		"value"=>"title"
	 * );
	 * dump(0=='unselect');      //true
	 * dump(0==(int)'unselect'); //true
	 * ---
	 * 
	 * @return string
	 */
	public function render(){
		$name 		=$this->name;
		$value		=$this->value;
		$attr 		=$this->attr;
		$options  	=(array)$this->options;
		$className	=$this->className;
		
		$tpl="<select name='{$name}' {$attr} class='{$className}'>";
		foreach ($options as $optionValue=>$optionTitle){
			//[选项值，选项标题]
			$selected='';
			if($value!==null && $optionValue==$value){
				$selected=" selected='selected' ";
			}
			$tpl.="<option value='{$optionValue}' {$selected} >{$optionTitle}</option>";
		}
		$tpl.="</select>";
		return $tpl;
	}
}
?>
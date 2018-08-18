<?php
namespace qing\form_control;
/**
 * Select表单域
 * 
 * @property options array
 * - 选项
 * [ 
 * 	[value,title,optionAttr]
 * 	[value,title,optionAttr]
 * ]
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */
class Select extends Control{
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
	 * @return string
	 */
	public function render(){
		$name 		=$this->name;
		$value		=$this->value;
		$attr 		=$this->attr;
		$options  	=(array)$this->options;
		$className	=$this->className;
		$className>'' &&  $className="class='{$className}'";
		
		$tpl="<select name='{$name}' {$className} {$attr} >";
		foreach($options as $option){
			$option=(array)$option;
			//[选项值，选项标题，选项属性]
			list($optionValue,$optionTitle)=(array)$option;
			$optionAttr=@$option[2];
			if($value!==null && $optionValue==$value){
				$selected=" selected='selected' ";
			}else{
				$selected='';
			}
			$tpl.="<option value='{$optionValue}' {$selected} {$optionAttr}>{$optionTitle}</option>";
		}
		$tpl.="</select>";
		return $tpl;
	}
}
?>
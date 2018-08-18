<?php
namespace qing\form_control;
/**
 * Form表单
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */
class Form extends Control{
   /**
    * 表单操作
    * 
	* @var string
	*/
	public $action='';
	/**
	 * 请求方式
	 * 
	 * @var string
	 */
	public $method='';
	/**
	 * 是否有文件上传
	 * 
	 * @name isfileupload
	 * @var string
	 */
	public $isupload=false;
	
	/**
	 * @see \form_control\Control::render()
	 */
	public function render(){
		
	}
	/**
	 * form标签开始
	 * <form enctype="multipart/form-data" action="" method='post'/></form>
	 *
	 * @return string
	 */
	public function begin(){
		$className=$this->className;
		$attr	  =$this->attr;
		
		$action	  =$this->action;
		$method	  =$this->method;
		$isupload =$this->isupload;
		
		if($isupload){
			$attr.=' enctype="multipart/form-data" ';
		}
		
		return "<form action='{$action}' method='{$method}' class='{$className}' {$attr} >";
	}
	/**
	* form标签结束
	* </form>
	* @return string
	*/
	public function end(){
		return "</form>";
	}
}
?>
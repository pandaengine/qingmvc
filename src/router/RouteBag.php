<?php
namespace qing\router;
/**
 * 路由包
 * 包含路由信息
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class RouteBag{
	/**
	 * 模块
	 * 
	 * @var string
	 */
	public $module;
	/**
	 * 控制器
	 *
	 * @var string
	 */
	public $ctrl;
	/**
	 * 操作
	 *
	 * @var string
	 */
	public $action;
	/**
	 * 多余的参数
	 * demo01.php/m/c/a/id/123/name/xiaowang
	 *
	 * @deprecated 只使用标准的$_GET $_POST
	 * @var array
	 */
	public $params=[];
	/**
	 * 是否是转发
	 *
	 * @var boolean
	 */
	public $forward=false;
	/**
	 * 闭包等
	 *
	 * @name Parser
	 * @var string
	 */
	public $other;
	/**
	 * 类型
	 * 让适配器选择解析
	 * 
	 * @value plugin
	 * @name Parser
	 * @var string
	 */
	public $type;
	/**
	 * 控制器类名
	 * class/ctrlClass
	 * 
	 * @var string
	 */
	public $className;
	/**
	 * 构造函数
	 * 
	 * @param string $module
	 * @param string $ctrl
	 * @param string $action
	 */
	public function __construct($module,$ctrl,$action=''){
		$this->module=$module;
		$this->ctrl  =$ctrl;
		$this->action=$action;
	}
	/**
	 * @return $this
	 */
	public function params(array $params=[]){
		$this->params=$params;
		return $this;
	}
	/**
	 * @return $this
	 */
	public function other($other){
		$this->other=$other;
		return $this;
	}
	/**
	 * @return $this
	 */
	public function forward($forward){
		$this->forward=(bool)$forward;
		return $this;
	}
	/**
	 * @return $this
	 */
	public function type($type){
		$this->type=$type;
		return $this;
	}
	/**
	 * @return $this
	 */
	public function className($className){
		$this->className=$className;
		return $this;
	}
}
?>
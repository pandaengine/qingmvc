<?php
namespace qing\widget;
use qing\mv\ModelAndView;
use qing\view\V;
/**
 * Widget小部件类
 * 纯数据视图渲染
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
abstract class Widget implements WidgetInterface{
	/**
	 * 小部件名称
	 * 小部件视图寻址时用到
	 * 
	 * @var string
	 */
	public $widgetName;
	/**
	 * 基于哪个模块
	 * 小部件视图寻址时用到
	 * 
	 * @var string
	 */
	public $moduleName;
	/**
	 * 处理小部件视图显示
	 * 抽象方法，widget必须实现该方法
	 * 
	 * @param array $data
	 */
	abstract public function run($data);
	/**
	 * @param string $widget
	 */
	public function setWidgetName($widget){
		$this->widgetName=$widget;
	}
	/**
	 * @param string $module
	 */
	public function setModuleName($module){
		$this->moduleName=$module;
	}
	/**
	 * 捕获返回
	 * 
	 * @param string $viewName
	 * @param array  $vars
	 * @param string $return
	 */
	protected function display($viewName='',array $vars=[]){
		echo $this->render($viewName,$vars,true);
	}
	/**
	 * 模板显示调用内置的模板引擎显示方法
	 * 
	 * @param string $viewName
	 * @param array  $vars
	 * @return string
	 */
	protected function render($viewName='',array $vars=[]){
		if(!$viewName){
			$viewName=strtolower($this->widgetName);
		}
		//取得真实的模版路径
		$mv=new ModelAndView($viewName,$vars);
		$mv->viewPath=$this->getViewPath();
		//渲染视图
		return V::render($mv);
	}
	/**
	 * 
	 * @param string $viewName
	 */
	protected function getViewPath(){
		return com('widget')->getViewPath($this->moduleName);
	}
	/**
	 * 传入数据为数组
	 * 
	 * @param array $data
	 */
	public function dataArray($data){
		if(!is_array($data)){
			throw new \Exception('widget data is not array: '.$this->widgetName);
		}
	}
	/**
	 * 传入数据为字符串
	 * 
	 * @param string $data
	 */
	public function dataString($data){
		if(!is_string($data)){
			throw new \Exception('widget data is not string: '.$this->widgetName);
		}
	}
	/**
	 * 传入数据为空
	 *
	 * @param string $data
	 */
	public function dataEmpty($data){
		if(!empty($data)){
			throw new \Exception('widget data is not empty: '.$this->widgetName);
		}
	}
}
?>
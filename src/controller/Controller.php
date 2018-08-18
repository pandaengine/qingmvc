<?php
namespace qing\controller;
/**
 * 控制器类
 * 保持简单
 * 
 * 注意: 
 * - 不要添加任何public函数，可能被当作操作函数访问，下划线_开头不允许访问
 * - 添加的public内部函数，都要以下划线_开头!
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Controller implements ControllerInterface{
	/**
	 * 当前请求控制器名称
	 *
	 * @var string
	 */
	public $ctrlName;
	/**
	 * 当前请求操作名称
	 *
	 * @var string
	 */
	public $actionName;
	/**
	 * 限制http访问权限|转发不受限制
	 * 
	 * @var boolean
	 */
	public $httpAccess=true;
	/**
	 * 限制所有的访问权限|转发也受限制
	 *
	 * @var boolean
	 */
	public $access=true;
	/**
	 * 执行操作
	 * _开头不允许访问
	 * 
	 * @final 不能重写/避免和操作同名
	 * @param string $ctrlName
	 * @param string $actionName   操作名称
	 * @param array  $actionParams 操作参数
	 * @return mixed
	 */
	final public function _runAction($ctrlName,$actionName,array $actionParams=[]){
		$this->ctrlName	 =$ctrlName;
		$this->actionName=$actionName;
		//aop:操作前置操作
		$result=$this->beforeAction();
		if($result!==true){
			//#非true直接返回|false/mv/string
			return $result;
		}
		//#执行操作
		$result=call_user_func_array([$this,$actionName],$actionParams);
		//aop:操作后置操作，可以修改返回结果
		$this->afterAction();
		return $result;
	}
	/**
	 * - 该方法被调用在操作执行时【所有过滤器已经执行】
	 * - 你可以覆盖该方法，为操作做最后的准备
	 * 
	 * @ 注意： 不能重写为public,会被作为控制器操作访问
	 * @return boolean
	 */
	protected function beforeAction(){
		return true;
	}
	/**
	 * - 操作执行完毕后调用该方法
	 * - 你可以在控制器中覆盖这个方法去做一些后处理的操作
	 * 
	 * @ 注意： 不能重写为public,会被作为控制器操作访问
	 * @deprecated
	 */
	protected function afterAction(){
	}
	/**
	 * @debug 可能被当作操作函数访问
	 */
	//public function test(){dump(__METHOD__);}
	/**
	 * 返回mv由前端控制器渲染
	 * 
 	 * @param string $viewName  模版文件
	 * @param array  $vars      模版变量
	 * @return \qing\mvc\ModelAndView
	 */
	protected function render($viewName='',array $vars=[]){
		return new \qing\mv\ModelAndView($viewName,$vars);
	}
	/**
	 * 捕获返回
	 * 
	 * @param string  $viewFile  模版文件
	 * @param array   $vars      模版变量
	 */
	protected function capture($viewFile='',array $vars=[]){
		$mv=$this->render($viewFile,$vars);
		$mv->capture=true;
		//#
		$txt=(string)app()->renderView($mv);
		return $txt;
	}
	/**
	 * 直接显示输出
	 *
	 * @param string  $viewFile  模版文件
	 * @param array   $vars      模版变量
	 */
	protected function display($viewFile='',array $vars=[]){
		$res=$this->capture($viewFile,$vars);
		echo $res;
		return MV_NULL;
	}
}
?>
<?php
namespace qing\adapter;
use qing\com\Component;
use qing\exceptions\http\NotFoundActionException;
use qing\exceptions\http\NotFoundControllerException;
/**
 * 闭包处理器适配器
 * 
 * @name FunctionAdapter
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ClosureAdapter extends Component implements AdapterInterface{
	/**
	 * 当前模块
	 *
	 * @var \qing\app\Module
	 */
	public $module;
	/**
	 * 使用适配器执行处理器
	 *
	 * @name handle
	 * @param \qing\router\RouteBag $route
	 */
	public function run(\qing\router\RouteBag $route){
		$ctrlName  =$route->ctrl;
		$actionName=$route->action;
		//#导入控制函数所在文件
		$filename=$this->getCtrlFile($ctrlName);
		if(!file_exists($filename)){
			throw new NotFoundControllerException($ctrlName);
		}
		require_once $filename;
		//#
		$actionName=$this->getActionName($ctrlName,$actionName);
		if(!function_exists($actionName)){
			throw new NotFoundActionException($actionName);
		}
		//return call_user_func_array($actionName,[]);
		return call_user_func($actionName);
	}
	/**
	 * \controller\index_ctrl.php
	 * 
	 * @param string $ctrlName
	 * @return string
	 */
	public function getCtrlFile($ctrlName){
		return main()->getBasePath().DS.DKEY_CTRL.DS.$ctrlName.'_ctrl'.PHP_EXT;
	}
	/**
	 * - 操作函数名称/包含命名空间
	 * \main\controller\user\index
	 *
	 * @param string $ctrlName
	 * @param string $actionName
	 * @return string
	 */
	public function getActionName($ctrlName,$actionName){
		return main()->namespace.'\\'.DKEY_CTRL.'\\'.$ctrlName.'\\'.$actionName;
	}
}
?>
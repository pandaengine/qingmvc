<?php
namespace qing\view\finder;
/**
 * 按控制器分类视图文件定位器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CtrlFinder{
	/**
	 * 获取主视图模版文件
	 * 
	 * - 包含控制器目录|自动追加
	 * - path\theme\ctrl\action|view.html
	 * - ctrl:action
	 *
	 * @param $viewName 视图名称
	 * @return string
	 */
	public static function getViewName($viewName){
		//#只有主应用是webapp/且只有一个webapp
		$route=\Qing::$app->ROUTE;
		if(!$viewName){
			//#空
			$ctrl	=lcfirst($route->ctrl);
			$action =$route->action;
		}else{
			//##自动从控制器目录下找
			$ctrl	=lcfirst($route->ctrl);
			$action =$viewName;
		}
		return $ctrl.DS.$action;
	}
}
?>
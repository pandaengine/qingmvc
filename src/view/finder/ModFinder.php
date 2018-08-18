<?php
namespace qing\view\finder;
/**
 * 包含模块文件定位器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ModFinder extends CtrlFinder{
	/**
	 * 获取主视图模版文件
	 * 
	 * - 主动包含控制器
	 * - path\theme\mod\ctrl\action|view.html
	 * - ctrl:action
	 * 
	 * @param string $viewName
	 * @return string
	 */
	public static function getViewName($viewName){
		//#只有主应用是webapp/且只有一个webapp
		$route=app()->ROUTE;
		$viewName=parent::getViewName($viewName);
		return $route->module.DS.$viewName;
	}
}
?>
<?php
namespace qing\view\finder;
/**
 * 按操作名定位
 * 视图文件定位器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ActionFinder{
	/**
	 * 获取主视图模版文件
	 * 
	 * - 从视图根目录开始寻找
	 * - path\theme\action|view.html
	 * 
	 * @param string $viewName
	 * @return string
	 */
	public static function getViewName($viewName){
		if($viewName==''){
			//#只有主应用是webapp/且只有一个webapp
			$route=app()->ROUTE;
			//#不指定视图文件|默认为控制器名称
			$viewName=lcfirst($route->ctrl);
		}
		return $viewName;
	}
}
?>
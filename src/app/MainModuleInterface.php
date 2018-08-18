<?php
namespace qing\app;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface MainModuleInterface{
	/**
	 * 主模块执行前方法
	 * 
	 * @param \qing\router\RouteBag $routeBag
	 * @return boolean
	 */
	public function beforeMainModule($routeBag);
}
?>
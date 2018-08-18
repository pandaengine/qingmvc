<?php
namespace qing\app;
/**
 * 模块接口
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface ModuleInterface{
	/**
	 * 模块初始化
	 */
	public function initModule();
	/**
	 * 模块执行前方法
	 * 只有当前模块经过该方法
	 * 
	 * - 可以配置组件/权限验证
	 *
	 * @param \qing\router\RouteBag $routeBag
	 * @return boolean
	 */
	public function beforeModule($routeBag);
	/**
	 * 模块执行后方法
	 * 
	 * @param \qing\router\RouteBag $routeBag
	 */
	public function afterModule($routeBag);
}
?>
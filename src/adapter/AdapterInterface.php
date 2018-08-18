<?php
namespace qing\adapter;
/**
 * - Adapter：处理器适配器
 * - 可适配，通过Adapter可以支持任意的类作为处理器；
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface AdapterInterface{
	/**
	 * 使用适配器执行处理器
	 *
	 * @param \qing\router\RouteBag $route
	 */
	public function run(\qing\router\RouteBag $route);
}
?>
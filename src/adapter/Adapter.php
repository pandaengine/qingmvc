<?php
namespace qing\adapter;
use qing\com\Component;
/**
 * 抽象拦截器
 * 
 * @name AbstractAdapter
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Adapter extends Component implements AdapterInterface{
	/**
	 * 使用适配器执行处理器
	 *
	 * @name handle
	 * @param \qing\router\RouteBag $route
	 */
	public function run(\qing\router\RouteBag $route){
		
	}
}
?>
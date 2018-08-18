<?php
namespace qing\container;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface AutoInjectorInterface{
	/**
	 * 使用set方法的参数依赖自动注入属性
	 *
	 * @param string $propName
	 * @param mixed  $instance
	 */
	public function setProperty($instance,$propName);
	/**
	 * 创建实例，并解析构造函数约束，注入依赖
	 *
	 * @param string $className 类名称
	 * @return mixed
	 */
	public function createInstance($className);
}
?>
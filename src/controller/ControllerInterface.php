<?php
namespace qing\controller;
/**
 * 控制器接口
 * 
 * - 所有方法都必须是公有，这是接口的特性
 * - 类可以实现多个接口，用逗号来分隔多个接口的名称
 * - 接口也可以继承，通过使用 extends 操作符
 * - 使用接口常量|const b='Interface constant';
 * ---
 * - 接口是一种开放给外部访问的规范
 * - 不能开发访问的则不要使用接口约束/接口规范
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface ControllerInterface{
	/**
	 * 执行操作
	 * _开头不允许访问
	 * 
	 * @final 不能重写/避免和操作同名
	 * @param string $actionName   操作名称
	 * @param array  $actionParams 操作参数
	 * @return mixed
	 */
	 public function _runAction($ctrlName,$actionName,array $actionParams=[]);
}
?>
<?php
namespace qing\facades;
/**
 * 环境探测器
 * ------------
 * 如果您想要更灵活的环境侦测方式，可以传递一个 闭包（Closure） 给 detectEnvironment 函数
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Config extends Facade{
	/**
	 * @return string
	 */
	protected static function getName(){
		return 'config';
	}
}
?>
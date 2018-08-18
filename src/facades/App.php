<?php
namespace qing\facades;
use qing\Qing;
/**
 *
 * @see \qing\app\App
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class App extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	public static function getName(){
		return '\qing\app\App';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\app\App 
	 */
	public static function getInstance(){
		return Qing::$app;
	}
}
?>
<?php
namespace qing\facades;
/**
 * 注意：
 * - 不要使用FacadeSgt单例
 * - 每次都是新实例，都要重新实例化
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Where extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	public static function getName(){
		return '\qing\db\Where';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\db\Where 
	 */
	public static function getInstance(){
		return new \qing\db\Where();
	}
}
?>
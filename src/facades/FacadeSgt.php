<?php
namespace qing\facades;
use qing\utils\Instance;
/**
 * 注意：和Facade的区别
 *  
 * - Facade: 获取组件
 * - FacadeC: 从容器中获取实例
 * - FacadeSgt: 单例管理
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
abstract class FacadeSgt extends Facade{
	/**
	 * 从容器中获取对应实例
	 *
	 * @param string $name
	 * @return mixed
	 */
	public static function getInstance(){
		return Instance::sgt(static::getName());
	}
}
?>
<?php
namespace qing\com;
/**
 * 组件创建器接口
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface ComCreatorInterface{
	/**
	 * 创建组件
	 *
	 * @return void
	 */
	public function create();
	/**
	 * 设置组件
	 *
	 * @return void
	 */
	public function setup($com);
}
?>
<?php
namespace qing\com;
/**
 * 应用组件必须实现的接口
 * 在应用完成配置后，会调用每个已经加载的应用组件的init方法。
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface ComponentInterface{
	/**
	 *
	 * @param string $comName
	 * @return $this
	 */
	public function comName($comName);
	/**
	 * 组件初始化
	 * - 只有通过getComponent获取组件，创建组件，注入属性之后才会调用该方法
	 * - 组件初始化方法，创建组件的时候会被自动调用，注意：只调用一次
	 * - 不能在构造函数调用|还未注入属性
	 */
	public function initComponent();
}
?>
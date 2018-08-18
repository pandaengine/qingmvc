<?php
namespace qing\widget;
/**
 * 小部件接口
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface WidgetInterface{
	/**
	 * 小部件名称
	 * 
	 * @param string $widget
	 */
	public function setWidgetName($widget);
	/**
	 * @param string $module
	 */
	public function setModuleName($module);
	/**
	 * @param array $data
	 */
	public function run($data);
}
?>
<?php
namespace qing\view;
/**
 * 视图接口
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface ViewInterface{
	/**
	 * 渲染视图
	 * 
	 * @param \qing\mv\ModelAndView $mv
	 */
	public function render(\qing\mv\ModelAndView $mv);
}
?>
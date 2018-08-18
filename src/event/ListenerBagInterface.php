<?php
namespace qing\event;
/**
 * 事件处理器接口
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface ListenerBagInterface{
	/**
	 * 获取监听器名称
	 *
	 * @return string
	 */
	public function getName();
}
?>
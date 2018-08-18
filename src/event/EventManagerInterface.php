<?php 
namespace qing\event;
use Exception;
/**
 * 事件管理器接口
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface EventManagerInterface{
	/**
	 * 是否绑定有监听器
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function has($name);
	/**
	 * - 绑定一次性的监听器
	 * - 监听器执行一次后移除
	 * - 不管事件点触发多少次
	 *
	 * @see attach one once
	 * @param string 	$name 	            事件点
	 * @param callback  $listener   监听器
	 * @param number    $priority	监听器优先级
	 */
	public function once($name,$listener,$priority=10);
	/**
	 * 绑定注册事件监听器/处理器
	 *
	 * array 键值不能是float
	 * 一个事件处理器必须是有效的php回调。
	 * [处理器,调用优先级]
	 *
	 * @name bind on attach register
	 * @param string 	$name 	            事件点
	 * @param callback  $listener   监听器
	 * @param number    $priority	监听器优先级/int/float
	 */
	public function bind($name,$listener,$priority=10);
	/**
	 * - 解绑某个事件点的所有监听器
	 * - 解绑某个事件点的某个监听器
	 *
	 * @name  unbind detach unregister
	 * @param string $name	 	事件名称
	 * @param mixed  $listener 	监听器
	 */
	public function unbind($name,$listener='');
	/**
	 * 触发事件点，执行监听器链
	 *
	 * @name trigger listen emit fire
	 * @param string $name
	 * @param mixed  $data
	 * @return \qing\event\Event
	 */
	public function trigger($name,$data=null);
}
?>
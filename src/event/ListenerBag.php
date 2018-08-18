<?php
namespace qing\event;
/**
 * 事件监听器/处理器包裹器
 * 
 * - 监听器包裹器
 * - 包裹一个监听器，设置多余信息
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ListenerBag implements ListenerBagInterface{
	/**
	 * 监听器名称
	 *
	 * @var string
	 */
	public $name;
	/**
	 * 监听器只执行一次
	 * 
	 * @var bool
	 */
	public $once=false;
	/**
	 * 包裹监听器
	 *
	 * @var mixed
	 */
	public $listener;
	/**
	 * 构造函数
	 *
	 * @param mixed $listener
	 * @param string $name
	 */
	public function __construct($listener,$name=''){
		$this->listener=$listener;
		$this->name    =$name;
	}
	/**
	 * 获取监听器名称
	 * 
	 * @return string
	 */
	public function getName(){
		if($this->name){
			return $this->name;
		}
		if($this->listener && is_object($this->listener)){
			return spl_object_hash($this->listener);
		}
		return '';
	}
	/**
	 * @param string $name
	 * @return $this
	 */
	public function name($name){
		$this->name=$name;
		return $this;
	}
	/**
	 * @param boolean $once
	 * @return $this
	 */
	public function once($once){
		$this->once=$once;
		return $this;
	}
	/**
	 * @param mixed $listener
	 * @return $this
	 */
	public function listener($listener){
		$this->listener=$listener;
		return $this;
	}
}
?>
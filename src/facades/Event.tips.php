<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 * @see \qing\event\EventManager
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Event extends Facade{
	/**
	 * 组件id
	 *
	 * @return string
	 */
	static public function getName(){
		return 'event';
	}
	/**
	 * 获取组件
	 *
	 * @return \qing\event\EventManager
	 */
	static public function getInstance(){
	
	}
	/**
	 *
	 */
	static public function getId($name,$priority){
		return static::getInstance()->getId($name,$priority);
	}
	/**
	 *
	 */
	static public function has($name){
		return static::getInstance()->has($name);
	}
	/**
	 *
	 */
	static public function once($name,$listener,$priority=10){
		return static::getInstance()->once($name,$listener,$priority);
	}
	/**
	 *
	 */
	static public function bind($name,$listener,$priority=10){
		return static::getInstance()->bind($name,$listener,$priority);
	}
	/**
	 *
	 */
	static public function unbind($name,$listener=''){
		return static::getInstance()->unbind($name,$listener);
	}
	/**
	 *
	 */
	static public function trigger($name,$data=''){
		return static::getInstance()->trigger($name,$data);
	}
	/**
	 *
	 */
	static public function runListener($listener,$data){
		return static::getInstance()->runListener($listener,$data);
	}
	/**
	 *
	 */
	static public function unsort($name){
		return static::getInstance()->unsort($name);
	}
	/**
	 *
	 */
	static public function sort($name){
		return static::getInstance()->sort($name);
	}
	/**
	 *
	 */
	static public function getListeners($name){
		return static::getInstance()->getListeners($name);
	}
	/**
	 *
	 */
	static public function getEvents(){
		return static::getInstance()->getEvents();
	}
	/**
	 *
	 */
	static public function getHooks(){
		return static::getInstance()->getHooks();
	}
}
?>
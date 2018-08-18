<?php 
/**
 * 创建一个对象实例
 *
 * @name e
 * @param mixed $data
 * @param mixed $target
 * @return \qing\event\EventBag
 */
function event($data=null,$target=null){
	return new \qing\event\EventBag($data,$target);
}
/**
 * 事件处理器
 * 
 * @return \qing\event\EventManager
 */
function e_event(){
	return coms()->getEvent();
}
/**
 * 
 * @param string $name
 * @param mixed  $handler
 * @param number $priority
 */
function e_once($name,$handler,$priority=10){
	e_event()->once($name,$handler,$priority);
}
/**
 *
 * @param string $name
 * @param mixed  $handler
 * @param number $priority
 */
function e_bind($name,$handler,$priority=10){
	e_event()->bind($name,$handler,$priority);
}
/**
 * 
 * @param string $name
 * @param string $index
 */
function e_unbind($name,$index=false){
	e_event()->unbind($name,$index);
}
/**
 * \qing\event\Event
 * 
 * @param string $name
 * @param mixed  $event
 * @return \qing\event\Event
 */
function e_listen($name,$event=null){
	return e_event()->listen($name,$event);
}
/**
 * @param string $name
 * @return boolean
 */
function e_listened($name){
	return e_event()->listened($name);
}
/**
 * @param string $name
 * @return boolean
 */
function e_bound($name){
	return e_event()->bound($name);
}
/**
 * 应用初始化后事件
 * 
 * @param string $name
 * @return boolean
 */
function e_app_inited($handler,$priority=10){
	return e_bind(\qing\app\App::E_APP_INITED,$handler,$priority);
}
?>
<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @see \qing\adapter\ControllerAdapter
 */
class Adapter extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return 'adapter';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\adapter\ControllerAdapter 
	 */
	static protected function getInstance(){
		
	}
	/**
	 * 
	 */
	static public function run($routeBag){
		static::getInstance()->run($routeBag);
	}
}
?>
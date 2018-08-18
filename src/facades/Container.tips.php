<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @see \qing\di\Container
 */
class Container extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return 'container';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\di\Container 
	 */
	static protected function getInstance(){
		
	}
	/**
	 * 
	 */
	static public function setMaps($maps){
		static::getInstance()->setMaps($maps);
	}
	/**
	 * 
	 */
	static public function getMaps(){
		static::getInstance()->getMaps();
	}
	/**
	 * 
	 */
	static public function get($id){
		static::getInstance()->get($id);
	}
	/**
	 * 
	 */
	static public function create($config){
		static::getInstance()->create($config);
	}
	/**
	 * 
	 */
	static public function getProperty($propValue){
		static::getInstance()->getProperty($propValue);
	}
	/**
	 * 
	 */
	static public function has($id){
		static::getInstance()->has($id);
	}
	/**
	 * 
	 */
	static public function sets($list){
		static::getInstance()->sets($list);
	}
	/**
	 * 
	 */
	static public function set($id,$conf){
		static::getInstance()->set($id,$conf);
	}
}
?>
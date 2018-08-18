<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @see \qing\cache\file\FileCache
 */
class Cache extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return 'cache@main';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\cache\file\FileCache 
	 */
	static protected function getInstance(){
		
	}
	/**
	 * 
	 */
	static public function get($key){
		static::getInstance()->get($key);
	}
	/**
	 * 
	 */
	static public function set($key,$value,$expire=0){
		static::getInstance()->set($key,$value,$expire);
	}
	/**
	 * 
	 */
	static public function delete($key){
		static::getInstance()->delete($key);
	}
	/**
	 * 
	 */
	static public function clear(){
		static::getInstance()->clear();
	}
	/**
	 * 
	 */
	static public function getAll(){
		static::getInstance()->getAll();
	}
}
?>
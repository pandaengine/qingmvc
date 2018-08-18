<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @see \qing\router\Router
 */
class Router extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return 'router';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\router\Router 
	 */
	static protected function getInstance(){
		
	}
	/**
	 * 
	 */
	static public function takeover($route){
		static::getInstance()->takeover($route);
	}
	/**
	 * 
	 */
	static public function pushHandler($handler){
		static::getInstance()->pushHandler($handler);
	}
	/**
	 * 
	 */
	static public function unshiftHandler($handler){
		static::getInstance()->unshiftHandler($handler);
	}
	/**
	 * 
	 */
	static public function parse(){
		static::getInstance()->parse();
	}
	/**
	 * 
	 */
	static public function validateRoute($routeBag){
		static::getInstance()->validateRoute($routeBag);
	}
}
?>
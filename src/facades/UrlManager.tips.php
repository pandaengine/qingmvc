<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @see qing\url\UrlManager
 */
class UrlManager extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return 'urlManager';
	}
	/**
	 * 获取组件 
	 * 
	 * @return qing\url\UrlManager 
	 */
	static protected function getInstance(){
		
	}
	/**
	 * 
	 */
	static public function defineGlobalUrl(){
		static::getInstance()->defineGlobalUrl();
	}
	/**
	 * 
	 */
	static public function defineRouteUrl($module,$ctrl,$action){
		static::getInstance()->defineRouteUrl($module,$ctrl,$action);
	}
	/**
	 * 
	 */
	static public function create($module,$ctrl,$action='',$params=[],$generator=''){
		static::getInstance()->create($module,$ctrl,$action,$params,$generator);
	}
	/**
	 * 
	 */
	static public function pushGenerator($generator){
		static::getInstance()->pushGenerator($generator);
	}
	/**
	 * 
	 */
	static public function getRootUrl(){
		static::getInstance()->getRootUrl();
	}
}
?>
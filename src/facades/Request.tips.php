<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @see \qing\http\Request
 */
class Request extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static public function getName(){
		return 'request';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\http\Request 
	 */
	static public function getInstance(){
		
	}
	/**
	 * 
	 */
	static public function getMethod(){
		static::getInstance()->getMethod();
	}
	/**
	 * 
	 */
	static public function isGet(){
		static::getInstance()->isGet();
	}
	/**
	 * 
	 */
	static public function isPost(){
		static::getInstance()->isPost();
	}
	/**
	 * 
	 */
	static public function isAjax(){
		static::getInstance()->isAjax();
	}
	/**
	 *
	 */
	static public function onlyGet(){
		static::getInstance()->onlyGet();
	}
	/**
	 *
	 */
	static public function onlyPost(){
		static::getInstance()->onlyPost();
	}
	/**
	 *
	 */
	static public function input($key){
		static::getInstance()->input($key);
	}
	/**
	 * 
	 */
	static public function isSecure(){
		static::getInstance()->isSecure();
	}
	/**
	 * 
	 */
	static public function getScheme(){
		static::getInstance()->getScheme();
	}
	/**
	 * 
	 */
	static public function getProtocol(){
		static::getInstance()->getProtocol();
	}
	/**
	 * 
	 */
	static public function getPathInfo($safe=''){
		static::getInstance()->getPathInfo($safe);
	}
	/**
	 * 
	 */
	static public function getPhpSelf($safe=''){
		static::getInstance()->getPhpSelf($safe);
	}
	/**
	 * 
	 */
	static public function getHttpHost(){
		static::getInstance()->getHttpHost();
	}
	/**
	 * 
	 */
	static public function getHost(){
		static::getInstance()->getHost();
	}
	/**
	 * 
	 */
	static public function getUserAgent(){
		static::getInstance()->getUserAgent();
	}
	/**
	 * 
	 */
	static public function getRequestUri(){
		static::getInstance()->getRequestUri();
	}
	/**
	 * 
	 */
	static public function getRequestTime(){
		static::getInstance()->getRequestTime();
	}
	/**
	 * 
	 */
	static public function getScriptName(){
		static::getInstance()->getScriptName();
	}
	/**
	 * 
	 */
	static public function getScriptBasename(){
		static::getInstance()->getScriptBasename();
	}
	/**
	 * 
	 */
	static public function getRootpath(){
		static::getInstance()->getRootpath();
	}
	/**
	 * 
	 */
	static public function getClientIp(){
		static::getInstance()->getClientIp();
	}
	/**
	 * 
	 */
	static public function getReferer($safe='1'){
		static::getInstance()->getReferer($safe);
	}
	/**
	 * 
	 */
	static public function getQueryString(){
		static::getInstance()->getQueryString();
	}
}
?>
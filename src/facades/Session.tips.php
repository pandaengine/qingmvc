<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 * 
 * @see \qing\session\Session
 * @author xiaowang <736523132@qq.com>
 * @copyright 2013 qingmvc http://qingmvc.com
 */
class Session extends Facade{
	/**
	 * @return string
	 */
	protected static function getName(){
		return 'session';
	}
	/**
	 * session组件
	 *
	 * @return \qing\session\Session
	 */
	static public function getInstance(){
		return coms()->getSession();
	}
	/**
	 * 
	 */
	static public function autostart(){
		static::getInstance()->autostart();
	}
	/**
	 *
	 */
	static public function start(){
		static::getInstance()->start();
	}
	/**
	 * 设置session的值
	 *
	 * @param string $key
	 * @param string $value
	 * @param boolean $commit 是否要提交
	 */
	static public function set($key,$value,$commit=false){
		static::getInstance()->set($key,$value);
	}
	/**
	 *
	 * @param string $key
	 */
	static public function get($key){
		return static::getInstance()->get($key);
	}
	/**
	 *
	 */
	static public function destroy(){
		return static::getInstance()->destroy();
	}
}
?>
<?php
namespace qing\facades;
use qing\Qing;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @see \qing\app\App
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class App extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	public static function getName(){
		return '\qing\app\App';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\app\App 
	 */
	public static function getInstance(){
		return Qing::$app;
	}
	/**
	 * 
	 */
	public static function setNamespaces($list){
		return static::getInstance()->setNamespaces($list);
	}
	/**
	 * 
	 */
	public static function setAliases($list){
		return static::getInstance()->setAliases($list);
	}
	/**
	 * 
	 */
	public static function getContainer(){
		return static::getInstance()->getContainer();
	}
	/**
	 * 
	 */
	public static function getModules(){
		return static::getInstance()->getModules();
	}
	/**
	 * 
	 */
	public static function hasModule($modName){
		return static::getInstance()->hasModule($modName);
	}
	/**
	 * 
	 */
	public static function setModules($modules){
		return static::getInstance()->setModules($modules);
	}
	/**
	 * 
	 */
	public static function setModule($name,$module){
		return static::getInstance()->setModule($name,$module);
	}
	/**
	 * 
	 */
	public static function getMainModule(){
		return static::getInstance()->getMainModule();
	}
	/**
	 * 
	 */
	public static function getModule($modName){
		return static::getInstance()->getModule($modName);
	}
}
?>
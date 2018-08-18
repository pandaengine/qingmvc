<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Coms extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	public static function getName(){
		return '\qing\com\Coms';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\com\Coms 
	 */
	public static function getInstance(){
		
	}
	/**
	 * 
	 */
	public static function create($service,$id=''){
		return static::getInstance()->create($service,$id);
	}
	/**
	 * 
	 */
	public static function set($id,$service){
		return static::getInstance()->set($id,$service);
	}
	/**
	 * 
	 */
	public static function sets($services){
		return static::getInstance()->sets($services);
	}
	/**
	 * 
	 */
	public static function get($id){
		return static::getInstance()->get($id);
	}
	/**
	 * 
	 */
	public static function hasInstance($id){
		return static::getInstance()->hasInstance($id);
	}
	/**
	 * 
	 */
	public static function has($id){
		return static::getInstance()->has($id);
	}
	/**
	 * 
	 */
	public static function removeInstance($id){
		return static::getInstance()->removeInstance($id);
	}
	/**
	 * 
	 */
	public static function remove($id){
		return static::getInstance()->remove($id);
	}
	/**
	 * 
	 */
	public static function getService($id){
		return static::getInstance()->getService($id);
	}
	/**
	 * 
	 */
	public static function setServices($srvs){
		return static::getInstance()->setServices($srvs);
	}
	/**
	 * 
	 */
	public static function getServices(){
		return static::getInstance()->getServices();
	}
	/**
	 * 
	 */
	public static function comName($comName){
		return static::getInstance()->comName($comName);
	}
}
?>
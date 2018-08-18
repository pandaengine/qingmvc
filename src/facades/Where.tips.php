<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Where extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	public static function getName(){
		return '\qing\db\Where';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\db\Where 
	 */
	public static function getInstance(){
		
	}
	/**
	 * 
	 */
	public static function getBindings(){
		return static::getInstance()->getBindings();
	}
	/**
	 * 
	 */
	public static function getWhere($bindOn='1'){
		return static::getInstance()->getWhere($bindOn);
	}
	/**
	 * 
	 */
	public static function set($field,$value,$operator='',$connector='and'){
		return static::getInstance()->set($field,$value,$operator,$connector);
	}
	/**
	 * 
	 */
	public static function push($sql,$connector='and'){
		return static::getInstance()->push($sql,$connector);
	}
	/**
	 * 
	 */
	public static function a_n_d($sql){
		return static::getInstance()->a_n_d($sql);
	}
	/**
	 * 
	 */
	public static function o_r($sql){
		return static::getInstance()->o_r($sql);
	}
	/**
	 * 
	 */
	public static function eq($field,$value,$connector='and'){
		return static::getInstance()->eq($field,$value,$connector);
	}
	/**
	 * 
	 */
	public static function gt($field,$value,$connector='and'){
		return static::getInstance()->gt($field,$value,$connector);
	}
	/**
	 * 
	 */
	public static function ge($field,$value,$connector='and'){
		return static::getInstance()->ge($field,$value,$connector);
	}
	/**
	 * 
	 */
	public static function lt($field,$value,$connector='and'){
		return static::getInstance()->lt($field,$value,$connector);
	}
	/**
	 * 
	 */
	public static function le($field,$value,$connector='and'){
		return static::getInstance()->le($field,$value,$connector);
	}
	/**
	 * 
	 */
	public static function between($field,$valueStart,$valueEnd,$connector='and'){
		return static::getInstance()->between($field,$valueStart,$valueEnd,$connector);
	}
	/**
	 * 
	 */
	public static function in($field,$value,$connector='and'){
		return static::getInstance()->in($field,$value,$connector);
	}
	/**
	 * 
	 */
	public static function like($field,$value,$connector='and'){
		return static::getInstance()->like($field,$value,$connector);
	}
	/**
	 * 
	 */
	public static function notlike($field,$value,$connector='and'){
		return static::getInstance()->notlike($field,$value,$connector);
	}
	/**
	 * 
	 */
	public static function gleft($connector='and'){
		return static::getInstance()->gleft($connector);
	}
	/**
	 * 
	 */
	public static function gright(){
		return static::getInstance()->gright();
	}
}
?>
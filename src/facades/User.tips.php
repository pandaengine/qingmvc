<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @see \qing\session\User
 */
class User extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return 'user';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\session\User
	 */
	static protected function getInstance(){
		
	}
	/**
	 * 
	 */
	public static function get($key,$def=''){
		return static::getInstance()->get($key,$def);
	}
	/**
	 * 
	 */
	public static function set($key,$value){
		return static::getInstance()->set($key,$value);
	}
	/**
	 * 
	 */
	public static function setAdmin($admin){
		return static::getInstance()->setAdmin($admin);
	}
	/**
	 * 
	 */
	public static function isAdmin(){
		return static::getInstance()->isAdmin();
	}
	/**
	 * 
	 */
	public static function isAdminLogged(){
		return static::getInstance()->isAdminLogged();
	}
	/**
	 * 
	 */
	public static function isLogged(){
		return static::getInstance()->isLogged();
	}
	/**
	 * 
	 */
	public static function isLoggedAndActive(){
		return static::getInstance()->isLoggedAndActive();
	}
	/**
	 * 
	 */
	public static function isActive(){
		return static::getInstance()->isActive();
	}
	/**
	 * 
	 */
	public static function gid($gid){
		return static::getInstance()->gid($gid);
	}
	/**
	 * 
	 */
	public static function nickname($nickname){
		return static::getInstance()->nickname($nickname);
	}
	/**
	 * 
	 */
	public static function status($status){
		return static::getInstance()->status($status);
	}
	/**
	 * 
	 */
	public static function login($uid,$username,$admin=0){
		return static::getInstance()->login($uid,$username,$admin);
	}
	/**
	 * 
	 */
	public static function logout(){
		return static::getInstance()->logout();
	}
	/**
	 * 
	 */
	public static function getData(){
		return static::getInstance()->getData();
	}
}
?>
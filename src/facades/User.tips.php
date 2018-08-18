<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @see \qing\session_user\UserSession
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
	static public function setup(){
		static::getInstance()->setup();
	}
	/**
	 * 
	 */
	static public function getKey($key){
		static::getInstance()->getKey($key);
	}
	/**
	 * 
	 */
	static public function get($key,$def=''){
		static::getInstance()->get($key,$def);
	}
	/**
	 * 
	 */
	static public function set($key,$value){
		static::getInstance()->set($key,$value);
	}
	/**
	 * 
	 */
	static public function setAdmin($admin){
		static::getInstance()->setAdmin($admin);
	}
	/**
	 * 
	 */
	static public function isAdmin(){
		static::getInstance()->isAdmin();
	}
	/**
	 * 
	 */
	static public function isAdminLogged(){
		static::getInstance()->isAdminLogged();
	}
	/**
	 * 
	 */
	static public function isLogged(){
		static::getInstance()->isLogged();
	}
	/**
	 * 
	 */
	static public function isLoggedAndActive(){
		static::getInstance()->isLoggedAndActive();
	}
	/**
	 * 
	 */
	static public function isActive(){
		static::getInstance()->isActive();
	}
	/**
	 * 
	 */
	static public function gid($gid){
		static::getInstance()->gid($gid);
	}
	/**
	 * 
	 */
	static public function nickname($nickname){
		static::getInstance()->nickname($nickname);
	}
	/**
	 * 
	 */
	static public function status($status){
		static::getInstance()->status($status);
	}
	/**
	 * 
	 */
	static public function login($uid,$username,$admin=0){
		static::getInstance()->login($uid,$username,$admin);
	}
	/**
	 * 
	 */
	static public function logout(){
		static::getInstance()->logout();
	}
	/**
	 * 
	 */
	static public function getData(){
		static::getInstance()->getData();
	}
}
?>
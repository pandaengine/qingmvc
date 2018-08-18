<?php
namespace qing\facades;
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
}
?>
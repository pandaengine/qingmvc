<?php
namespace qing\facades;
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
}
?>
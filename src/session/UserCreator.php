<?php 
namespace qing\session;
use qing\com\ComCreator;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UserCreator extends ComCreator{
	/**
	 * trait
	 */
	use \qing\session\SessionConfigTrait;
	/**
	 * @see \qing\com\ComCreator::create()
	 */
	public function create(){
		$user=new User();
		$user->persistor=coms()->getSession();
		return $user;
	}
}
?>
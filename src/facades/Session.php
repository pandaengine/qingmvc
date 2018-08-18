<?php
namespace qing\facades;
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
}
?>
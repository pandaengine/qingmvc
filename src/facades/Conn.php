<?php
namespace qing\facades;
/**
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Conn extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	public static function getName(){
		return 'db@main';
	}
}
?>
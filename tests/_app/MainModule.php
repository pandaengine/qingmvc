<?php
namespace main;
use qing\app\MainModule as MM;
/**
 * 模块
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 qingmvc http://qingmvc.com
 */
class MainModule extends MM{
	/**
	 * @return boolean
	 */
	public function beforeModule($routeBag){
		return true;
	}
}
?>
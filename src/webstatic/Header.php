<?php
namespace qing\webstatic;
use qing\http\Cache;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Header{
	/**
	 *
	 */
	public static function css(){
		header('Content-Type: text/css; charset=UTF-8;');
		Cache::on(0);//0:永不过期
	}
	/**
	 *
	 */
	public static function js(){
		header('Content-Type: application/javascript; charset=UTF-8;');
		Cache::on(0);//0:永不过期
	}
}
?>
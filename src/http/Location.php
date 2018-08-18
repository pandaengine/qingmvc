<?php
namespace qing\http;
/**
 * 链接跳转
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Location{
	/**
	 * 重定向到一个指定的链接
	 *
	 * @param string  $location
	 * @param integer $statusCode 默认为302
	 * @param boolean $exit  	     终止代码运行
	 */
	public static function header($location,$statusCode=302,$exit=false){
		header("Location: {$location}",true,$statusCode);
		if($exit){
			exit();
		}
	}
	/**
	 * 重定向到一个指定的链接
	 *
	 * @param string  $location
	 * @param integer $statusCode 默认为302
	 * @param boolean $exit  	     终止代码运行
	 */
	public static function send_response($location,$statusCode=302,$exit=false){
		$response=new \qing\http\Response($statusCode);
		$response->setLocation($location);
		$response->send();
		if($exit){
			exit();
		}
	}
}
?>
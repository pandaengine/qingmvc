<?php
namespace qing\http;
/**
 * 报头工具
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Header{
	/**
	 * 内容类型报头
	 * application/javascript
	 * 
	 * @param string $type
	 * @param string $charset
	 */
	public static function content_type($type="text/html",$charset="utf-8"){
		header("Content-type:{$type};charset={$charset}");
	}
	/**
	 * 编码报头
	 * 
	 * @param string $type
	 */
	public static function utf8($type="text/html"){
		self::content_type($type);
	}
	/**
	 * 发送状态码200,302,404
	 * 
	 * header('haha:hahaha',true,404);
	 * header('HTTP/1.1 404 haha');
	 * 
	 * @param integer $statusCode 404/302
	 */
	public static function status($statusCode){
		header($_SERVER['SERVER_PROTOCOL'].' '.$statusCode);
		//$response=new \qing\http\Response($statusCode);
		//$response->send();
	}
}
?>
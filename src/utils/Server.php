<?php
namespace qing\utils;
/**
 * @see $_SERVER
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class IP{
	/**
	 * 客户端IP地址
	 * REMOTE_ADDR: 浏览当前页面的用户的 IP地址
	 */
	static public function client_ip(){
		return $_SERVER['REMOTE_ADDR'];
	}
	/**
	 * 服务器IP
	 * SERVER_ADDR: 当前运行脚本所在的服务器的 IP 地址
	 */
	static public function server_ip(){
		return $_SERVER['SERVER_ADDR'];
	}
	/**
	 * 当前运行脚本所在的服务器的主机名。
	 */
	static public function server_name(){
		return $_SERVER['SERVER_NAME'];
	}
}
?>
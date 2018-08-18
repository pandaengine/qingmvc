<?php
namespace qing\session;
/**
 * cookie助手
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CookieX{
	/**
	 * cookie组件
	 *
	 * @param string $key
	 * @param string $value
	 * @return \qing\session\Cookie
	 */
	static public function create($key,$value){
		return new Cookie($key,$value);
	}
	/**
	 *
	 * @param string $key
	 * @param string $value
	 */
	static public function send($key,$value){
		$cookie=new Cookie($key,$value);
		$cookie->send();
	}
	/**
	 * php原生函数
	 *
	 * @param string $key
	 * @param string $value
	 */
	static public function set($key,$value){
		setcookie($key,$value);
	}
	/**
	 *
	 * @param string $key
	 */
	static public function get($key){
		return $_COOKIE[$key];
	}
	/**
	 * 删除一个cookie的值
	 * 要删除一个 Cookie，应该设置过期时间为过去，以触发浏览器的删除机制。
	 * 
	 * - 设置值为空
	 * - 设置过期时间为过去时间
	 *
	 * @tutorial 把值清空即可
	 * @param string $name
	 */
	static public function remove($name){
		$value ='';
		$expire=time()-24*3600;
		setcookie($name,$value,$expire);
	}
}
?>
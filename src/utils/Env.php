<?php 
namespace qing\utils;
/**
 * 操作系统环境变量
 * getenv - 获取一个环境变量的值
 * 
 * // getenv() 使用示例
 * $ip = getenv('REMOTE_ADDR');
 * 
 * // 或简单仅使用全局变量（$_SERVER 或 $_ENV）
 * $ip = $_SERVER['REMOTE_ADDR'];
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Env{
	/**
	 * 获取一个环境变量的值
	 * 
	 * @param string $key
	 * @return string
	 */
	public static function get($key){
		return getenv($key);
	}
	/**
	 * 添加 setting 到服务器环境变量
	 * 环境变量仅存活于当前请求期间,在请求结束时环境会恢复到初始状态
	 * putenv("UNIQID=$uniqid");
	 * 
	 * @param string $key
	 * @param string $value
	 * @return string
	 */
	public static function set($key,$value){
		return putenv($key.'='.$value);
	}
}
?>
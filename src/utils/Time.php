<?php
namespace qing\utils;
/**
 * 秒(s) 100分秒(ds)= 1000 毫秒(ms) = 1,000,000 微秒(μs) = 1,000,000,000 纳秒(ns) = 1,000,000,000,000 皮秒(ps)
 * 
 * - microtime(true) : 返回浮点数
 * - microtime(): 字符串  "msec sec" "微妙 秒"
 * 
 * @link http://php.net/manual/zh/function.microtime.php
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Time{
	/**
	 * 取得当前时间精确到微妙
	 * 
	 * # 注意是微秒不是毫秒
	 * 毫秒：Millisecond
	 * 微妙：microsecond
	 * 
	 */
	public static function utime(){
		list($usec, $sec) = explode(" ", microtime());
		return date('Y-m-d H:i:s',$sec).' '.$usec.'s';
	}
	/**
	 * 根据时间戳计算微妙
	 *
	 * @return string
	 */
	public static function usec($utime){
		return number_format((float)$utime-(int)$utime,4);
	}
}
?>
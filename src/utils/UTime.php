<?php 
namespace qing\utils;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UTime{
	/**
	 * 取得当前时间 精确到微妙
	 * list($usec, $sec) //list — 把数组中的值赋给一些变量 ,按数组下标顺序赋值.
	 * $usec = 0.57812900;
	 $sec = 1286935327;
	 microtime 0.57812900 1286935327
	 差8个小时的原因是切换了时区
	 */
	public static function utime(){
		list($usec, $sec) = explode(" ", microtime());
		return date('Y-m-d H:i:s',$sec).' '.$usec.'s';
	}
	/**
	 * 计算毫秒
	 *
	 * @return string
	 */
	public static function usec($utime){
		return number_format((float)$utime-(int)$utime,4);
	}
}
?>
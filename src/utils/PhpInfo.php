<?php 
namespace qing\utils;
/**
 * php信息
 * 
 * @see phpinfo ini_get php_uname
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class PhpInfo{
	/**
	 * 功能：返回当前PHP所运行的系统的信息
	 * PHP_OS WINNT
	 */
	public static function isWindows(){
		return strtoupper(substr(PHP_OS,0,3))==='WIN'?true:false;
	}
	/**
	 * 除非多次调用，否则不推荐，占用内存直到脚本退出
	 * 避免多次计算
	 * 
	 * @deprecated
	 */
	public static function isWindowsMulti(){
		static $_isWindows=null;
		if($_isWindows===null){
			//只执行一次
			$_isWindows=self::isWindows();
		}
		return $_isWindows;
	}
	/**
	 * 默认情况下，
	 *  -1 : 在第一个版本低于第二个时,返回 -1
	 *  0  : 如果两者相等，返回 0；
	 *  1  : 第二个版本更低时则返回 1。
	 *  
	 * 当使用了可选参数 operator 时，如果关系是操作符所指定的那个，函数将返回 TRUE，否则返回 FALSE。
	 * 
	 * version_compare(PHP_VERSION, '7.0.0') >= 0
	 * version_compare(PHP_VERSION, '7.0.0', '>=')
	 * version_compare(PHP_VERSION, '7.0.0', '<')
	 * 
	 * - phpversion() - 获取当前的PHP版本
	 * - php_uname() - 返回运行 PHP 的系统的有关信息
	 * 
	 * //php7,支持标量类型声明int/string/float/bool/array/declare(strict_types=1);
	 * $php7=version_compare(PHP_VERSION, '7.0.0')>0;
	 * 
	 * @param string $v1
	 * @param string $v2
	 * @param string $operator
	 */
	public static function version_compare($v2,$operator='>='){
		return version_compare(PHP_VERSION,$v2,$operator);
	}
}
?>
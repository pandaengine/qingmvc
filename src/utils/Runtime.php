<?php 
namespace qing\utils;
/**
 * 运行时，时间和内存消耗计算
 * 
 * @see memory_get_usage - 返回分配给 PHP 的内存量
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Runtime{
	/**
	 * 栈先进后出
	 *
	 * @var array
	 */
	protected static $stack=[];
	/**
	 *
	 * @var array
	 */
	protected static $memstack=[];
	/**
	 * 开始位置
	 *
	 * @param string $cat 计算分组
	 */
	public static function begin($cat){
		if(!isset(self::$stack[$cat])){
			self::$stack[$cat]=[];
		}
		array_push(self::$stack[$cat],microtime(true));
	}
	/**
	 * 结束位置
	 *
	 * @param string $cat 计算分组
	 * @return 单位:秒/s
	 */
	public static function end($cat){
		$time_begin=array_pop(self::$stack[$cat]);
		if($time_begin==null){
			throw new \Exception('异常');
		}
		$time_end=microtime(true);
		$runtime=number_format(($time_end-$time_begin),4);
		return $runtime;
	}
	/**
	 * 开始位置
	 *
	 * @param string $cat 计算分组
	 */
	public static function mem_begin($cat){
		if(!isset(self::$memstack[$cat])){
			self::$memstack[$cat]=[];
		}
		array_push(self::$memstack[$cat],memory_get_usage());
	}
	/**
	 * 结束位置
	 *
	 * @param string $cat 计算分组
	 * @return 单位: B/比特
	 */
	public static function mem_end($cat){
		$mem_begin=array_pop(self::$memstack[$cat]);
		if($mem_begin==null){
			throw new \Exception('异常');
		}
		$mem_end=memory_get_usage();
		return $mem_end-$mem_begin;
	}
}
?>
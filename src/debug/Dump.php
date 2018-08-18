<?php 
namespace qing\debug;
/**
 * 打印对象
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Dump{
	/**
	 * 已声明类
	 */
	public static function classes(){
		dump(get_declared_classes());
	}
	/**
	 * 已声明接口
	 */
	public static function interfaces(){
		dump(get_declared_interfaces());
	}
	/**
	 * 已声明trait
	 */
	public static function traits(){
		dump(get_declared_traits());
	}
	/**
	 * 已定义用户常量
	 */
	public static function constants(){
		dump(get_defined_constants(true)['user']);
	}
	/**
	 * 已定义用户函数
	 */
	public static function functions(){
		//函数名称都是小写
		dump(get_defined_functions()['user']);
	}
	/**
	 * 已定义系统内置函数
	 */
	public static function functions_internal(){
		dump(get_defined_functions()['internal']);
	}
	/**
	 * 已注册autoload函数
	 * spl可以注册多个
	 */
	public static function autoload_functions(){
		dump(spl_autoload_functions());
	}
}
?>
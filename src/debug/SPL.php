<?php 
namespace qing\debug;
/**
 * PHP标准库 (SPL)
 * 
 * @link http://php.net/manual/zh/book.spl.php
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SPL{
	/**
	 * 
	 */
	public static function autoload_functions(){
		dump(spl_autoload_functions());
	}
	/**
	 * 返回所有可用的SPL类
	 */
	public static function classes(){
		dump(spl_classes());
	}
	/**
	 * - 只是加载函数，不实例化，也不执行函数
	 * - 第一个注册的autoload已经加载文件了，不会再调用下一个autoload函数
	 */
	public static function autoload_call(){
		spl_autoload_register(function($className) {
			var_dump(__METHOD__.'  '.$className);
		});
		
		spl_autoload_call('C1');
		spl_autoload_call('C2');
		spl_autoload_call(__CLASS__);
		spl_autoload_call(__CLASS__.'2');
		spl_autoload_call(__CLASS__);
		spl_autoload_call(__NAMESPACE__.'\SPLNotLoad');
		spl_autoload_call(__NAMESPACE__.'\SPLNotLoad2');
		spl_autoload_call(__NAMESPACE__.'\SPLNotLoad');
	}
	/**
	 * //#调用spl默认的autoload
	 * spl_autoload($className);
	 * 
	 * - 类已经加载时，spl_autoload_call仍然会调用已经注册的autoload函数，
	 * - 所以autoload函数必须使用require_once，避免重复包含
	 */
	public static function autoload(){
		dump(__METHOD__);
		
// 		spl_autoload_register(function($className) {
// 			var_dump(__METHOD__.' spl_autoload_register  '.$className);
// 		});
// 		spl_autoload('C1');
// 		spl_autoload('C2');
// 		spl_autoload(__CLASS__);
		spl_autoload(__NAMESPACE__.'\SPLNotLoad');
		
		dump(__LINE__);
		
		spl_autoload_call('C1');
		spl_autoload_call(__CLASS__);
		spl_autoload_call(__CLASS__);
		spl_autoload_call(__CLASS__);
		spl_autoload_call(__NAMESPACE__.'\SPLNotLoad');
		spl_autoload_call(__NAMESPACE__.'\SPLNotLoad');
		spl_autoload_call(__NAMESPACE__.'\SPLNotLoad');
	}
	/**
	 * 
	 */
	public static function autoload_extensions(){
		dump(__METHOD__);
		dump(spl_autoload_extensions());
		dump(spl_autoload_extensions('.php,.inc'));
		dump(spl_autoload_extensions());
		dump(spl_autoload_extensions('.phpx,.php2,.inc'));
		dump(spl_autoload_extensions());
	}
	/**
	 * 返回指定对象的hash id
	 * 
	 * @param object $obj
	 * @return string
	 */
	public static function object_hash($obj){
		return spl_object_hash($obj);
	}
	/**
	 * 返回指定对象的hash id
	 *
	 * @param object $obj
	 * @return string
	 */
	public static function object_id($obj){
		//return spl_object_id($obj);
	}
}
?>
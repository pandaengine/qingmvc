<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 * 日志组件
 * 
 * @name log-facade 日志组件的入口
 * @see \qing\log\Logger
 * @see \qing\log\FileLogger
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Log extends Facade{
	/**
	 * @return string
	 */
	protected static function getName(){
		return 'logger';
	}
	/**
	 * 日志处理器
	 *
	 * @name log 系统函数名
	 * @return \qing\log\Logger
	 * @return \qing\log\FileLogger
	 */
	public static function getInstance(){
		
	}
	/**
	 * @param string $message
	 * @param array  $options
	 */
	public static function info($message,array $options=[]){
		return static::getInstance()->info($message,$options);
	}
	/**
	 * @param string $message
	 * @param array  $options
	 */
	public static function debug($message,array $options=[]){
		return static::getInstance()->debug($message,$options);
	}
	/**
	 * @param string $message
	 * @param array  $options
	 */
	public static function warn($message,array $options=[]){
		return static::getInstance()->warn($message,$options);
	}
	/**
	 * @param string $message
	 * @param array  $options
	 */
	public static function error($message,array $options=[]){
		return static::getInstance()->error($message,$options);
	}
	/**
	 * @param number $level
	 * @param string $message
	 * @param array  $options
	 */
	public static function record($level,$message,array $options=[]){
		return static::getInstance()->record($level,$message,$options);
	}	
}
?>
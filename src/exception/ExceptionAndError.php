<?php
namespace qing\exception;
use qing\Qing;
/**
 * 异常和错误处理器
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ExceptionAndError{
	/**
	 * 加载器是否已经被注册
	 *
	 * @var bool
	 */
	protected static $registered=false;
	/**
	 * 开启处理错误
	 *
	 * @var bool
	 */
	public static $handleErrorOn=false;
	/**
	 * 开启处理异常
	 *
	 * @var bool
	 */
	public static $handleExceptionOn=true;
	/**
	 * 注册
	 */
	public static function register(){
		if(self::$registered){
			return;
		}
		self::$registered=true;
		//错误报告设置
		self::error_reporting(APP_DEBUG===true);
		//#注册错误处理器
		if(self::$handleErrorOn){
			//set_error_handler(array($this,'handleError'));
		}
		//#注册异常处理器
		if(self::$handleExceptionOn){
			set_exception_handler([__CLASS__,'handleException']);
		}
		//#注册异常关闭处理器
		//register_shutdown_function(array($this,'handleShutdown'));
	}
	/**
	 * 移除所有异常处理器
	 */
	public static function unregister(){
		if(self::$registered){
			restore_exception_handler();
			restore_error_handler();
			self::$registered=false;
		}
	}
	/**
	 * 错误报告设置
	 *
	 * @see /php/logs/php_error_log
	 * @param boolean $debug
	 *  defined('APP_DEBUG') && APP_DEBUG
	 */
	public static function error_reporting($debug){
		if(defined('APP_ERROR_LEVEL')){
			//自定义报告等级:define('APP_ERROR_LEVEL',E_ALL ^ E_NOTICE);
			error_reporting(APP_ERROR_LEVEL);
		}else{
			error_reporting(E_ALL ^ E_NOTICE);
		}
		//错误报告等级，后面的设置会覆盖前面的设置
		if($debug){
			//直接在窗口显示错误显示
			@ini_set("display_errors","On");
		}else{
			//保存到服务器日志的错误等级
			//error_reporting(E_ALL ^ E_NOTICE);
			//关闭在窗口显示错误显示
			@ini_set("display_errors","Off");
		}
	}
	/**
	 * 处理错误
	 * -----
	 * 						处理函数					 处理级别
	 * set_error_handler(callable $error_handler [, int $error_types = E_ALL | E_STRICT ] )
	 * 重要的是要记住 error_types 里指定的错误类型都会绕过 PHP 标准错误处理程序， 除非回调函数返回了 FALSE。
	 * 
	 * error_reporting() 设置将不会起到作用而你的错误处理函数继续会被调用-不过你仍然可以获取 error_reporting 的当前值，并做适当处理。
	 *
	 * @param  int     $level|$errno 发起错误的等级
	 * @param  string  $message		发起错误的信息
	 * @param  string  $file		发起错误的文件
	 * @param  int     $line		发起错误的行数
	 * @throws \ErrorException
	 * @return true/false:返回false交由php内部处理器
	 */
	public static function handleError($level,$message,$file='',$line=0){
		if(!($level & error_reporting())){
			//按位与&这个错误码不包含自定义错误级别error_reporting中
			//返回false交由php内部处理器
			return false;
		}
		if($level==E_NOTICE){
			//错误处理器不能正确处理E_NOTICE|交由php内部处理器|可以使用error_reporting排除E_NOTICE等级
			return false;
		}
		throw new \ErrorException($message,$level,$level,$file, $line);
		//返回true则正确处理的错误|不再执行php内部处理器
		return true;
	}
	/**
	 * ---
	 * Error implements Throwable
	 * 自 PHP 7 以来，大多数错误抛出 Error 异常，也能被捕获。
	 * Error 和 Exception 都实现了 Throwable 接口。 PHP 7 起，处理程序的签名：
	 * void handler ( Throwable $ex )
	 * ---
	 * php7和低版本的兼容问题
	 * 
	 * 
	 * 处理异常/处理没有捕获的异常
	 * 
	 * @notice 在异常捕获处理程序的所有范围内不得抛出异常，否则造成[捕获/抛出]死循环!
	 * @param \Exception|\Error|\Throwable $exception        	
	 */
	public static function handleException($exception){
		//异常处理器不能抛出异常，所有的都捕获
		try{
			if(!$exception instanceof \Exception){
				//\Error|\Throwable|php7.0
				if(!interface_exists('\Throwable') || !$exception instanceof \Throwable){
					echo '异常无法处理';
					exit();
				}
				$exception=new ThrowableException($exception);
			}
			//
			$res=self::handleExceptionResult($exception);
			if(!$res){
				//默认处理器
				self::defHandler($exception);
			}
		
		}catch (\Exception $e){
			self::defHandler($e);
		}
	}
	/**
	 * @param \Exception $exception
	 */
	protected static function handleExceptionResult($exception){
		$app=Qing::$app;
		if(!$app || !$app::$inited_finished){
			//#应用未初始化，def处理器
			return false;
		}
		/* @var $handler \qing\exception\ExceptionHandler */
		$handler=com('exception');
		if(!$handler){
			//异常处理器未初始化，def处理器
			return false;
		}
		$handler->handle($exception);
		return true;
	}
	/**
	 * 默认处理器
	 * 一般不会抛出异常
	 * 
	 * @param \Exception $e
	 */
	protected static function defHandler(\Exception $e){
		$debug=APP_DEBUG;
		//$debug=false;
		if($debug){
			echo "<h3>默认异常处理器</h3>";
			echo "\n<pre>\n";
			echo $e->__toString();
			echo "\n</pre>\n";
		}else{
			$message	='系统错误';
			$serverInfo	='503';
			require __DIR__.'/views/def.html';
		}
	}
	/**
	 * 处理异常终止
	 * 特殊情况下处理致命错误和类似
	 * 
	 * @return void
	 */
	public static function handleShutdown(){
		return;
		if(!APP_DEBUG){
			return true;
		}
		$error=error_get_last();
		echo "<hr/><br/><br/>\n\n\n\n";
		echo __METHOD__."<br/><br/>\n\n\n\n";
		echo '<pre>';
		var_dump($error);
		echo '</pre>';
		return true;
	}
}
?>
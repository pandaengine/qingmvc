<?php
namespace qing\exception;
/**
 * ---
 * Error implements Throwable
 * 自 PHP 7 以来，大多数错误抛出 Error 异常，也能被捕获。 Error 和 Exception 都实现了 Throwable 接口。 PHP 7 起，处理程序的签名：
 * void handler ( Throwable $ex )
 * ---
 * 解决php7和低版本的兼容问题
 *
 * php7新特性：
 * ParseError
 * TypeError
 * 
 * @name ErrorException ThrowableException
 * @since php 7.0
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ThrowableException extends \Exception{
	/**
	 * 
	 * @#param \Exception|\Error|\Throwable $exception
	 * @#param \Throwable $exception
	 * @param \Exception $exception
	 */
	public function __construct(\Throwable $exception){
		if($exception instanceof \ParseError){
			$message ='Parse error: '.$exception->getMessage();
		}elseif ($exception instanceof \TypeError){
			$message ='Type error: '.$exception->getMessage();
		}else{
			$message ='Fatal error: '.$exception->getMessage();
		}
		//
		$this->file=$exception->getFile();
		$this->line=$exception->getLine();
		$this->setTrace($exception->getTrace());
		//
		parent::__construct($message,$exception->getCode());
	}
	/**
	 * 反射修改private私有属性
	 * 
	 * @param mixed $trace
	 */
	protected function setTrace($trace){
		$refProp=new \ReflectionProperty('\Exception','trace');
		$refProp->setAccessible(true);
		$refProp->setValue($this,$trace);
	}
}
?>
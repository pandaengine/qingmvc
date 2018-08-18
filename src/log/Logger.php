<?php 
namespace qing\log;
use qing\com\Component;
/**
 * 日志记录器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
abstract class Logger extends Component implements LoggerInterface{
	/**
	 * 追加日志|记录日志
	 *
	 * @name record
	 * @param number $level   日志等级
	 * @param string $message 日志消息
	 * @param array  $options 附加参数
	 */
	abstract public function log($level,$message,array $options=[]);
	/**
	 * 开启所有日志等级，即不限制等级
	 * 
	 * @deprecated
	 * @param string $message	日志消息
	 * @param array $options
	 */
	public function all($message,array $options=[]){
		return $this->log(__FUNCTION__,$message,$options);
	}
	/**
	 * debug/trace 追溯信息
	 * 
	 * @deprecated
	 * @param string $message
	 * @param array $options
	 */
	public function trace($message,array $options=[]){
		return $this->log(__FUNCTION__,$message,$options);
	}
	/**
	 * debug/调试日志
	 * 
	 * @param string $message
	 * @param array $options
	 */
	public function debug($message,array $options=[]){
		//return $this->log(__FUNCTION__,$message,$options);
		return $this->log(LoggerInterface::DEBUG,$message,$options);
	}
	/**
	 * 提示日志
	 * 
	 * @param string $message
	 * @param array $options
	 */
	public function info($message,array $options=[]){
		return $this->log(LoggerInterface::INFO,$message,$options);
	}
	/**
	 *
	 * @param string $message
	 * @param array $options
	 */
	public function notice($message,array $options=[]){
		return $this->log(LoggerInterface::NOTICE,$message,$options);
	}
	/**
	 * 警告日志
	 * 
	 * @param string $message
	 * @param array $options
	 */
	public function warning($message,array $options=[]){
		return $this->log(LoggerInterface::WARNING,$message,$options);
	}
	/**
	 * 错误日志
	 * 
	 * @param string $message
	 * @param array $options
	 */
	public function error($message,array $options=[]){
		return $this->log(LoggerInterface::ERROR,$message,$options);
	}
	/**
	 * @param string $message
	 * @param array $options
	 */
	public function critical($message,array $options=[]){
		return $this->log(LoggerInterface::CRITICAL,$message,$options);
	}
	/**
	 * @param string $message
	 * @param array $options
	 */
	public function alert($message,array $options=[]){
		return $this->log(LoggerInterface::ALERT,$message,$options);
	}
	/**
	 * @param string $message
	 * @param array $options
	 */
	public function emergency($message,array $options=[]){
		return $this->log(LoggerInterface::EMERGENCY,$message,$options);
	}
	/**
	 * 致命错误
	 * 
	 * @deprecated
	 * @see all
	 */
	public function fatal($message,array $options=[]){
		return $this->log(__FUNCTION__,$message,$options);
	}
}
?>
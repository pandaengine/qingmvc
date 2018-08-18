<?php
/**
 * 日志组件
 * 
 * @name log-facade 日志组件的入口
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
/**
 * 日志处理器
 *
 * @name log 系统函数名
 * @return \qlogger\Logger
 * @return \qing\log\Logger
 */
function logger(){
	return coms()->getLogger();
}
/**
 * @param string $message
 * @param array  $options
 */
function log_info($message,array $options=[]){
	return logger()->info($message,$options);
}
/**
 * @param string $message
 * @param array  $options
 */
function log_debug($message,array $options=[]){
	return logger()->debug($message,$options);
}
/**
 * @param string $message
 * @param array  $options
 */
function log_warn($message,array $options=[]){
	return logger()->warn($message,$options);
}
/**
 * @param string $message
 * @param array  $options
 */
function log_error($message,array $options=[]){
	return logger()->error($message,$options);
}
/**
 * @param number $level
 * @param string $message
 * @param array  $options
 */
function log_record($level,$message,array $options=[]){
	return logger()->record($level,$message,$options);
}
?>
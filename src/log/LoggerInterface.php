<?php
namespace qing\log;
/**
 * psr-3-logger
 * 
 * 优先级，低到高
 * ALL < DEBUG < INFO < NOTICE < WARNING < ERROR < CRITICAL < ALERT < EMERGENCY < FATAL < OFF
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface LoggerInterface{
	//
	const OFF		= 'off';
	const EMERGENCY = 'emergency';
	const ALERT     = 'alert';
	const CRITICAL  = 'critical';
	const ERROR     = 'error';
	const WARNING   = 'warning';
	const NOTICE    = 'notice';
	const INFO      = 'info';
	const DEBUG     = 'debug';
	const ALL 		= 'all';
    /**
     * 紧急情况
     * 
     * @name emerg
     * @param string $message
     * @param array  $options
     * @return null
     */
    public function emergency($message,array $options=[]);
    /**
     * 警告
     * 
     * @param string $message
     * @param array $options
     * @return null
     */
    public function alert($message,array $options=[]);
    /**
     * 严重错误
     * 
     * @name crit
     * @param string $message
     * @param array $options
     * @return null
     */
    public function critical($message,array $options=[]);
    /**
     * 错误
     * 
     * @param string $message
     * @param array $options
     * @return null
     */
    public function error($message,array $options=[]);
    /**
     * 警告
     * 
     * @name warn
     * @param string $message
     * @param array $options
     * @return null
     */
    public function warning($message,array $options=[]);
    /**
     * 注意
     * 
     * @param string $message
     * @param array $options
     * @return null
     */
    public function notice($message,array $options=[]);
    /**
     * 信息提示
     * 
     * 用户登录日志|sql查询日志
     *
     * @param string $message
     * @param array $options
     * @return null
     */
    public function info($message,array $options=[]);
    /**
     * 调试 信息
     * 
     * @param string $message
     * @param array $options
     * @return null
     */
    public function debug($message,array $options=[]);
    /**
     * 记录日志
     * 
     * @param mixed $level
     * @param string $message
     * @param array $options
     * @return null
     */
    public function log($level, $message,array $options=[]);
}
?>
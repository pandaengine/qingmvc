<?php 
namespace qing\debug;
/**
 * 调试，打印回溯追踪
 * 
 * @see debug_print_backtrace();
 * @see debug_backtrace()
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Backtrace{
	/**
	 * 打印程序运行追踪过程
	 */
	public static function dump(){
		//debug_backtrace 产生一条 PHP 的回溯跟踪(backtrace)。
		$trace          = debug_backtrace(); 
		// 	array_shift($trace);
		echo "<pre>";
		$traceInfo      = '';
		$time = date('y-m-d H:i:m');
		foreach ($trace as $t) {
			$traceInfo .= '[' . $time . '] ' . $t['file'] . ' (' . $t['line'] . ') ';
			$traceInfo .= $t['class'] . $t['type'] . $t['function'] . '(';
	
			$args=array();
			foreach ($t['args'] as $arg){
				if(is_object($arg)){
					// 				$arg=var_export($arg,true);
					$arg=get_class($arg);
				}else if(is_array($arg)){
					$arg=var_export($arg,true);
				}
				$args[]=$arg;
			}
			$traceInfo .= implode(', ', $args);
	
			$traceInfo .=')<br/>';
		}
		echo $traceInfo;
	}
	/**
	 * @param unknown $message
	 */
	public static function debug($message) {
		//debug_backtrace 产生一条 PHP 的回溯跟踪(backtrace)。
		$trace          = debug_backtrace();
		$e['message']   = $message;
		$e['file']      = $trace[0]['file'];
		$e['class']     = isset($trace[0]['class'])?$trace[0]['class']:'';
		$e['function']  = isset($trace[0]['function'])?$trace[0]['function']:'';
		$e['line']      = $trace[0]['line'];
		$traceInfo      = '';
		$time = date('y-m-d H:i:m');
		foreach ($trace as $t) {
			$traceInfo .= '[' . $time . '] ' . $t['file'] . ' (' . $t['line'] . ') ';
			$traceInfo .= $t['class'] . $t['type'] . $t['function'] . '(';
			$traceInfo .= implode(', ',array_map(array($this,'obj2str'),$t['args']) );
			$traceInfo .= ')<br/>';
		}
		$e['trace']     = $traceInfo;
	}
}
?>
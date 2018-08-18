<?php
namespace qing\utils;
/**
 * ob_ output buffering 输出缓存
 * ob_start Turn on output buffering
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Output{
	/**
	 * 即时输出提示信息
	 *
	 * @name flushout
	 * @param string $message
	 */
	static public function flush($message){
		echo $message;
		ob_flush();
		flush();
	}
	/**
	 * 捕获视图
	 *
	 * @name capture|catch
	 */
	static public function capture_begin(){
		//#捕获渲染视图内容返回
		//捕获页面缓存
		ob_start();
		ob_implicit_flush(0);
	}
	/**
	 * 捕获视图
	 */
	static public function capture_end(){
		//得到当前缓冲区的内容并删除当前输出缓冲区。
		return ob_get_clean();
	}
	/**
	 * @param string $viewFile
	 * @param array $vars
	 * @return string
	 */
	static public function capture($viewFile,array $vars=[]){
		//模板阵列变量分解成为独立变量
		extract($vars,EXTR_OVERWRITE);
		//捕获页面缓存
		ob_start();
		ob_implicit_flush(0);
		include $viewFile;
		// 获取并清空缓存
		$content=ob_get_clean();
		return $content;
	}
}
?>
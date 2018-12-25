<?php
namespace qing\interceptors;
use qing\interceptor\Interceptor;
use qing\str\Encoding;
/**
 * 输出编码
 * - win-cli输出gbk，避免乱码
 * 
 * @name \qing\session\SessionInterceptor
 * @author xiaowang <736523132@qq.com>
 * @copyright 2013 http://qingmvc.com all rights reserved.
 */
class OutputEncode extends Interceptor{
	/**
	 * 只在命令行起作用
	 *
	 * @var string
	 */
	public $cli=true;
	/**
	 * 编码
	 * 
	 * @var string
	 */
	public $encode='gbk';
	/**
	 * @see \qing\interceptor\Interceptor::preHandle()
	 */
	public function preHandle(){
		if($this->cli && PHP_SAPI=='cli'){
			//开启捕获页面缓存
			ob_start();
		}
		return true;
	}
	/**
	 * ob_get_clean() 实质上是一起执行了 ob_get_contents() 和 ob_end_clean()。
	 * 
	 * @see \qing\interceptor\Interceptor::afterCompletion()
	 */
	public function afterCompletion(){
		if($this->cli && PHP_SAPI=='cli'){
			$content=ob_get_clean();
			if($content){
				$content=Encoding::toGbk($content);
				echo $content;
			}
		}
	}
}
?>
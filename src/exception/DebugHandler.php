<?php
namespace qing\exception;
use qing\facades\Request;
/**
 * 异常处理器
 * debug模式
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class DebugHandler{
	/**
	 * 清除php输出缓存
	 * 
	 * @var bool
	 */
	public $clearOutputBuffers=false;
	/**
	 * 测试环境的处理器
	 *
	 * @param \Exception | \Error $exception
	 */
	public static function handle(\Exception $exception){
		//#格式化数据
		$vars=(array)DebugFormatter::format($exception);
		//ajax类型的异常信息
		if(Request::isAjax() || Request::isPost()){
			//#ajax
			$tpl=__DIR__.'/views/ajax/ajax.html';
		}else{
			$tpl=__DIR__.'/views/debug/debug.html';
		}
		//模板阵列变量分解成为独立变量
		extract($vars,EXTR_OVERWRITE);
		// 包含异常页面模板
		include $tpl;
	}
}
?>
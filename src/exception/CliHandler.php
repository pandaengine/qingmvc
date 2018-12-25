<?php
namespace qing\exception;
/**
 * 命令行模式
 * 
 * @see PHP_SAPI php_sapi_name()
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CliHandler{
	/**
	 * 清除php输出缓存
	 * 
	 * @var bool
	 */
	public $clearOutputBuffers=false;
	/**
	 * 测试环境的处理器
	 *
	 * @param \Exception | \Error $e
	 */
	public static function handle(\Exception $e){
		echo "\n\n[ Exception.CLI ]---\n";
		echo (string)$e;
		echo "\n\n";
	}
}
?>
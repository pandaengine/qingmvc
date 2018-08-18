<?php
namespace qing\exception;
/**
 * 异常处理器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ExceptionHandlerInterface{
	/**
	 * 异常处理
	 */
	public function handle(\Exception $exception);
}
?>
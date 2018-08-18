<?php
namespace qing\facades;
/**
 * 日志组件
 * 
 * @name log-facade 日志组件的入口
 * @see \qing\log\Logger
 * @see \qing\log\FileLogger
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Log extends Facade{
	/**
	 * @return string
	 */
	protected static function getName(){
		return 'logger';
	}
}
?>
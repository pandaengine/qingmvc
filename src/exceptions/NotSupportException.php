<?php
namespace qing\exceptions;
/**
 * 不支持
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NotSupportException extends Exception{
	/**
	 * 消息头
	 *
	 * @return string
	 */
	public function getTitle(){
		return \L::nonsupport();
	}
}
?>
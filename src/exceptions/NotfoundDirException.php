<?php
namespace qing\exceptions;
/**
 * 找不到文件或目录
 * 
 * file/dir not found
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NotfoundDirException extends Exception{
	/**
	 * 消息头
	 *
	 * @return string
	 */
	public function getTitle(){
		return '找不到目录: ';
	}
}
?>
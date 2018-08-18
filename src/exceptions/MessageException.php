<?php
namespace qing\exceptions;
/**
 * - 消息异常|DEBUG时抛出异常|生产环境显示错误消息|消息异常
 * - 错误异常
 * - 用户异常
 * - 可视异常
 * 
 * @name UserException
 * @name ErrorException
 * @name MessageException
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MessageException extends Exception{
	/**
	 * @param string $message  错误的信息
	 * @param integer $code    错误码
	 */
	public function __construct($message='',$code=0){
		$this->myMessage=$message;
		parent::__construct($message,$code);
	}
}
?>
<?php
namespace qing\exceptions;
/**
 * 系统异常
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Exception extends \Exception{
	/**
	 * 处理器
	 * 
	 * @var string
	 */
	public $handler='';
	/**
	 * http请求状态码   e.g.  403, 404, 500, etc.
	 *
	 * @var integer
	 */
	public $httpCode=0;
	/**
	 * 生产模式下可以显示的安全消息
	 * 
	 * @var string
	 */
	public $myMessage='';
	/**
	 * @var string
	 */
	public $title=null;
	/**
	 * @param string $handler
	 * @return $this
	 */
	public function handler($handler){
		$this->handler=$handler;
		return $this;
	}
	/**
	 * @param number $httpCode
	 * @return $this
	 */
	public function httpCode($httpCode){
		$this->httpCode=$httpCode;
		return $this;
	}
	/**
	 * @param string $myMessage
	 * @return $this
	 */
	public function myMessage($myMessage){
		//$this->message=$myMessage;
		$this->myMessage=$myMessage;
		return $this;
	}
	/**
	 * 消息头
	 * 设置null可以禁用消息头
	 * 
	 * @param string $title
	 * @return $this
	 */
	public function setTitle($title){
		$this->title=$title;
		return $this;
	}
	/**
	 * 消息头
	 * 
	 * @return string
	 */
	public function getTitle(){
		if($this->title===null){
			//禁用
			return '';
		}else{
			return $this->title;
		}
	}
}
?>
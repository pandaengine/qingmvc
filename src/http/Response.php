<?php 
namespace qing\http;
/**
 * 服务器响应输出
 * Response==Output==服务器响应
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Response extends ResponseHeader{
	/**
	 * 响应主体内容
	 * 
	 * @var string
	 */
	public $content;
	/**
	 * 构造函数
	 *
	 * @param int $status  响应状态码
	 * @return void
	 */
	public function __construct($status=200){
		$this->statusCode=(int)$status;
	}
	/**
	 * 设置内容
	 * 
	 * @param string $content
	 */
	public function setContent($content){
		$this->content=$content;
	}
	/**
	 * 取得内容
	 */
	public function getContent(){
		return $this->content;
	}
	/**
	 * 发送内容主体
	 */
	public function sendContent(){
		echo $this->content;
	}
	/**
	 * - 返回响应给客户端
	 * - 发送报头和内容
	 */
	public function send(){
		//#发送报头
		$this->sendHeader();
		//#发送cookie
		$this->sendCookies();
		//#发送正文
		$this->sendContent();
	}
	/**
	 * 格式化成字符串
	 * 
	 * @return string
	 */
	public function __toString(){
		$str='';
		$str.=$this->getHeaderString()."\r\n";
		$str.=$this->content;
		return $str;
	}
}
?>
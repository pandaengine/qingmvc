<?php
namespace qing\http;
/**
 * 响应头信息
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ResponseHeader{
	/**
	 * 报头信息列表
	 * [
	 *  'HTTP/1.1 200 OK',
	 * 	'Content-Type:text/html; charset=utf-8',
	 * ]
	 *
	 * @var    array
	 * @access protected
	 */
	protected $headers=[];
	/**
	 * 状态码
	 * 
	 * @var int
	 */
	public $statusCode=200;
	/**
	 * 自定义状态描述
	 * 
	 * @var string
	 */
	public $statusText;
	/**
	 * 常用默认状态码
	 * 
	 * @var array
	 */
	public $statusTexts=
	[
		// Success 2xx
		200=>'OK',
		// Redirection 3xx
		301=>'Moved Permanently',
		302=>'Found',
		303=>'See Other',
		// Client Error 4xx
		400=>'Bad Request',
		403=>'Forbidden',
		404=>'Not Found',
		405=>'Method Not Allowed',
		// Server Error 5xx
		500=>'Internal Server Error',
		503=>'Service Unavailable'
	];
	/**
	 * http响应编码/utf-8/gb2312/gbk
	 * 
	 * @var string
	 */
	public $charset='utf-8';
	/**
	 * 显示版权信息|安全起见不推荐
	 * - X-Powered-By:qingmvc.php
	 * - X-Powered-By:PHP/7.0.13
	 * - 为""可以禁止显示'X-Powered-By'
	 * 
	 * @var string
	 */
	public $poweredBy='none';
	/**
	 * 泄漏服务器信息的段
	 * Server:Apache/2.4.23 (Win32) OpenSSL/1.0.2h PHP/7.0.13
	 * X-Powered-By:PHP/7.0.13
	 * 
	 * - Server:是apache服务器加上去的，php无法处理
	 * 
	 * Header unset X-Powered-By
	 * Header unset Server
	 * 
	 * @name banFields
	 * @var array
	 */
	public $removeHeaders=[];
	/**
	 * text/html
	 * text/css
	 * image/gif
	 * application/javascript
	 * 
	 * @var array  内容类型缺省
	 */
	public $contentTypes=
	[
		'html'=>'text/html',
		'css' =>'text/css',
		'gif' =>'image/gif',
		'jpeg'=>'image/jpeg',
		'png' =>'image/png',
		'xml' =>'application/xml',
		'js'  =>'application/javascript',
		'json'  =>'application/json'
	];
	/**
	 * 获取默认状态描述
	 *
	 * @param  string $code
	 * @return string
	 */
	public function getDefStatusText($code){
		$code=(int)$code;
		if(isset($this->statusTexts[$code])){
			return $this->statusTexts[$code];
		}else{
			return '';
		}
	}
	/**
	 * 
	 * @param array $headers
	 */
	/*
	public function setHeaders(array $headers){
		foreach($headers as $key=>$value){
			$this->setHeader($key,$value);
		}
	}*/
	/**
	 * 添加一行报头信息
	 * Content-Type:text/html
	 * Location:http://qingmvc.com
	 * 
	 * @param string  $key   报头键值
	 * @param boolean $value 报头值
	 */
	public function setHeader($key,$value){
		$this->headers[$key]=$value;
	}
	/**
	 * 取值
	 *
	 * @param string  $key 报头键值
	 */
	public function getHeader($key){
		return $this->headers[$key];
	}
	/**
	 * 内容类型
	 * 
	 * @param  string $type js/json
	 */
	public function setContentType($type){
		$charset=$this->charset;
		if(!isset($this->contentTypes[$type])){
			throw new \qing\exceptions\NotfoundItem($type);
		}
		$type =$this->contentTypes[$type];
		$value=$type.";charset={$charset}";
		$this->setHeader('Content-Type',$value);
	}
	/**
	 * 取得属性
	 */
	public function getContentType(){
		return $this->getHeader('Content-Type');
	}
	/**
	 * 发送location报头，一般用于重定向
	 * Location:http://qingmvc.com
	 * 
	 * @param string $location
	 */
	public function setLocation($location){
		$this->setHeader("Location",$location);
	}
	/**
	 * 发送cookie时间
	 * 
	 * @see \qing\session\Cookie
	 */
	public function sendCookies(){
		
	}
	/**
	 * 发送http报头
	 * - dump(headers_sent());
	 * - dump(headers_list());
	 * - header_register_callback(function(){});
	 * - 依赖于设置：输出缓存(output_buffering)设置
	 * 
	 * headers_sent() : Checks if or where headers have been sent
	 * true:指示该报头是否替换之前的报头，或添加第二个报头。
	 * 	默认是 true（替换）。false（允许相同类型的多个报头）
	 * header($statusLine,true,$statusCode);
	 * 
	 * @return Response
	 */
	public function sendHeader(){
		if(headers_sent()){
			//报头已经发送，抛出异常
			//throw new \Exception('http报头已经发送');
			return false;
		}
		//#
		if($this->poweredBy){
			$this->setHeader('X-Powered-By',$this->poweredBy);
		}
		//#200|302|404
		$statusCode=(int)$this->statusCode;
		$statusText=(string)$this->statusText;
		$statusText=='' && $statusText=$this->getDefStatusText($statusCode);
		//#HTTP/1.1
		$protocol=$_SERVER['SERVER_PROTOCOL'];
		//#status:状态行 | HTTP/1.1 200 OK
		$statusLine="{$protocol} {$statusCode} {$statusText}";
		header($statusLine,true,$statusCode);
		
		//#headers:其他报头信息  Content-Type	:text/html; charset=utf-8
		foreach($this->headers as $key=>$value){
			header($key.':'.$value,true,$statusCode);
		}
		//#移除头部
		if($this->removeHeaders){
			foreach($this->removeHeaders as $header){
				//#先替换再移除
				header($header.':none',true,$statusCode);
				header_remove($header);
			}
		}
		return true;
	}
	/**
	 * 响应转换成字符串
	 * 
	 * 
	 *  HTTP/1.1 200 OK
	 *	Date: Thu, 25 Jun 2015 05:10:19 GMT
	 *	Server: Apache
	 *	Expires: Thu, 19 Nov 1981 08:52:00 GMT
	 *	Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
	 *	Pragma: no-cache
	 *	Content-Length: 217
	 *	Keep-Alive: timeout=5, max=100
	 *	Connection: Keep-Alive
	 *	Content-Type: text/html; charset=utf-8
	 *
	 * @return string
	 */
	public function getHeaderString(){
		$str='';
		//#200|302|404
		$statusCode=(int)$this->statusCode;
		//#HTTP/1.1
		$protocol=$_SERVER['SERVER_PROTOCOL'];
		//#status:状态行 | HTTP/1.1 200 OK
		$statusLine=sprintf("{$protocol} %s %s",$statusCode,$this->getStatusText($statusCode));
		//状态行
		$str.=$statusLine."\r\n";
		
		// headers:其他报头信息  Content-Type	:text/html; charset=utf-8
		foreach ($this->headers as $key=>$value){
			$str.=$key.':'.$value."\r\n";
		}
		if($this->poweredBy>''){
			$str.=$this->poweredBy."\r\n";
		}
		return $str;
	}
}
?>
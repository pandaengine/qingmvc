<?php
namespace qing\network;
/**
 * cUrl请求
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CUrl{
	//请求方式
	const POST	='POST';
	const GET	='GET';
	const DELETE='DELETE';
	const PUT	='PUT';
	//信息字段
	const HTTP_CODE		='http_code';
	const TOTAL_TIME	='total_time';
	const CONNECT_TIME	='connect_time';
	const HEADER_SIZE	='header_size';
	const CONTENT_TYPE	='content_type';
	const REDIRECT_URL	='redirect_url';
	/**
	 * @var bool
	 */
	public $post=false;
	/**
	 * 自动关闭
	 * 不自动关闭可以取得curl句柄
	 * 
	 * @var bool
	 */
	public $autoClose=true;
	/**
	 * CURLOPT_HEADER 启用时会将头文件的信息作为数据流输出。
	 * 打印报头，获取cookie等信息
	 * 
	 * @var bool
	 */
	public $withHeader=false;
	/**
	 * 允许 cURL 函数执行的最长秒数
	 * 单位毫秒
	 *
	 * @var number
	 */
	public $timeout=4000;
	/**
	 * 在尝试连接时等待的秒数
	 * 设置为0，则无限等待
	 * 单位毫秒
	 *
	 * @var number
	 */
	public $timeout_conn=600;
	/**
	 * curl句柄
	 *
	 * @var resource
	 */
	public $ch;
	/**
	 * 错误信息
	 *
	 * @var string
	 */
	public $error;
	/**
	 * 附加配置
	 * 
	 * @var bool
	 */
	protected $_options=[];
	/**
	 * 自定义报头
	 *
	 * @var bool
	 */
	protected $_headers=[];
	/**
	 * 请求结束后回调，可以获取请求信息
	 *
	 * @var bool
	 */
	protected $_onFinished;
	/**
	 * post请求
	 *
	 * @param string $url
	 * @param string $params
	 */
	public function post($url,$params=null){
		$this->post=true;
		return $this->query($url,$params);
	}
	/**
	 * get请求
	 *
	 * @param string $url
	 * @param string $params
	 */
	public function get($url,$params=null){
		return $this->query($url,$params);
	}
	/**
	 * get请求
	 *
	 * @param string $url
	 * @param string $params
	 */
	public function put($url,$params=null){
		$this->customRequest(self::PUT);
		return $this->query($url,$params);
	}
	/**
	 * get请求
	 *
	 * @param string $url
	 * @param string $params
	 */
	public function delete($url,$params=null){
		$this->customRequest(self::DELETE);
		return $this->query($url,$params);
	}
	/**
	 * 执行请求
	 * 
	 * @param string $url
	 * @param string $params
	 */
	public function query($url,$params=null){
		$this->error='';
		if($params && is_array($params)){
			$this->initParams($url,$params);
		}
		$options=$this->initOptions($url);
		//初始化会话
		$ch=curl_init();
		//设置传输选项
		curl_setopt_array($ch,$options);
		//执行会话
		$result=curl_exec($ch);
		//执行后事件
		if($this->_onFinished && $this->_onFinished instanceof \Closure){
			call_user_func($this->_onFinished,$ch);
		}
		if(!$result){
			//执行错误
			$this->error=curl_error($ch).' / '.curl_strerror(curl_errno($ch));
			return false;
		}
		//关联连接
		if($this->autoClose){
			curl_close($ch);
		}else{
			//不自动关闭句柄，供外部调用
			$this->ch=$ch;
		}
		return $result;
	}
	/**
	 * 手动关闭句柄
	 * 不开启自动关闭，则需要手动关闭
	 */
	public function close(){
		if(!$this->autoClose){
			curl_close($this->ch);
		}
	}
	/**
	 *
	 * @return $this
	 */
	protected function initOptions($url){
		$options=
		[
			CURLOPT_URL 				=> $url,
			CURLOPT_HEADER 				=> $this->withHeader,
			//CURLOPT_TIMEOUT 			=> $this->timeout,
			CURLOPT_TIMEOUT_MS 			=> $this->timeout,
			CURLOPT_CONNECTTIMEOUT_MS 	=> $this->timeout_conn,
			//TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
			CURLOPT_RETURNTRANSFER  	=> true,
			//TRUE 在完成交互以后强制明确的断开连接，不能在连接池中重用。
			CURLOPT_FORBID_REUSE  		=> true,
		];
		if($this->post){
			$options[CURLOPT_POST]=1;
		}
		//自定义报头
		if($this->_headers){
			$headers=[];
			foreach($this->_headers as $k=>$v){
				$headers[]=$k.': '.$v;
			}
			//CURLOPT_HTTPHEADER 设置 HTTP 头字段的数组。格式： array('Content-type: text/plain', 'Content-length: 100')
			$options[CURLOPT_HTTPHEADER]=$headers;
		}
		return $options + $this->_options;
	}
	/**
	 * 
	 * @param string $url
	 * @param array $params
	 */
	protected function initParams(&$url,array $params){
		if($this->post){
			//post参数
			$post=http_build_query($post);
			$this->option(CURLOPT_POSTFIELDS,$post);
		}else{
			//get参数
			if(strpos($url,'?')===false){
				//没有问号
				$conn='?';
			}else{
				//有问号
				$conn='&';
			}
			$url=$url.$conn.http_build_query($params);
		}
	}
	/**
	 *
	 * @param string $key
	 * @param string $value
	 * @return $this
	 */
	public function option($key,$value){
		$this->_options[$key]=$value;
		return $this;
	}
	/**
	 * $curl->setHeader('Referer','https://www.baidu.com');
	 * 
	 * @param string $key
	 * @param string $value
	 * @return $this
	 */
	public function setHeader($key,$value){
		$this->_headers[$key]=$value;
		return $this;
	}
	/**
	 * CURLOPT_USERAGENT 在HTTP请求中包含一个"User-Agent: "头的字符串。
	 *
	 * @param string $userAgent
	 * @return $this
	 */
	public function userAgent($userAgent){
		return $this->option(CURLOPT_USERAGENT,$userAgent);
	}
	/**
	 * CURLOPT_REFERER		在HTTP请求头中"Referer: "的内容。
	 * CURLOPT_AUTOREFERER	TRUE 时将根据 Location: 重定向时，自动设置 header 中的Referer:信息。
	 * 访问来源
	 * 
	 * @param string $referer
	 * @param string $auto
	 * @return $this
	 */
	public function referer($referer,$auto=true){
		return $this->option(CURLOPT_REFERER,$referer)
					->option(CURLOPT_AUTOREFERER,$auto);
	}
	/**
	 * 使用curl发送post请求,携带cookie
	 *
	 * @param string/array  $cookies a=aaa;b=bbb
	 * @return $this
	 */
	public function cookies($cookies){
		if(is_array($cookies)){
			$cookies=http_build_query($cookies);
		}else{
			$cookies=(string)$cookies;
		}
		return $this->option(CURLOPT_COOKIE,$cookies);
	}
	/**
	 * 请求发送的cookie，发送该文件的cookie
	 * ~cookiejar.log
	 *
	 * @param string $cookieFile
	 * @return $this
	 */
	public function cookieFile($file){
		return $this->option(CURLOPT_COOKIEFILE,$file);
	}
	/**
	 * 响应返回的cookie会保存到cookieJar
	 * 连接结束后，比如，调用 curl_close 后，保存 cookie 信息的文件。
	 * ~cookiejar.log
	 * 
	 * - cookieFile和cookieJar文件名可以相同
	 * - cookieFile：取得请求携带的cookie
	 * - cookieJar：响应cookie要保存的位置
	 *
	 * @param string $file
	 * @return $this
	 */
	public function cookieJar($file){
		return $this->option(CURLOPT_COOKIEJAR,$file);
	}
	/**
	 * TRUE 时将会根据服务器返回 HTTP 头中的 "Location: " 重定向。
	 * CURLOPT_MAXREDIRS: 指定最多的 HTTP 重定向次数，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的。
	 *
	 * @param string $follow
	 * @return $this
	 */
	public function followLocation($follow,$maxRedirs=3){
		return $this->option(CURLOPT_FOLLOWLOCATION,$follow)
					->option(CURLOPT_MAXREDIRS,$maxRedirs);
	}
	/**
	 * HTTP 请求时，使用自定义的 Method 来代替"GET"或"HEAD"。
	 * 
	 * @param string $method
	 * @return $this
	 */
	public function customRequest($method){
		return $this->option(CURLOPT_CUSTOMREQUEST,$method);
	}
	/**
	 * CURLOPT_SSL_VERIFYSTATUS: TRUE 验证证书状态。
	 * 
	 * @param string $peer
	 * @param string $host
	 * @return $this
	 */
	public function sslVerify($peer,$host){
		return $this->option(CURLOPT_SSL_VERIFYPEER,$peer)
					->option(CURLOPT_SSL_VERIFYHOST,$host);
	}
	/**
	 * 每次读入的缓冲的尺寸。
	 * 当然不保证每次都会完全填满这个尺寸。	在cURL 7.10中被加入。
	 *
	 * @param string $size
	 * @return $this
	 */
	public function bufferSize($size){
		return $this->option(CURLOPT_BUFFERSIZE,$size);
	}
	/**
	 * 捕获cURL连接资源句柄的信息
	 * 
	 * CURLINFO_HTTP_CODE - 最后一个收到的HTTP代码/http_code
	 * CURLINFO_TOTAL_TIME - 最后一次传输所消耗的时间/total_time
	 * CURLINFO_NAMELOOKUP_TIME - 名称解析所消耗的时间/namelookup_time
	 * CURLINFO_CONNECT_TIME - 建立连接所消耗的时间/connect_time
	 * ---
	 * CURLINFO_SIZE_UPLOAD - 以字节为单位返回上传数据量的总值/size_upload
	 * CURLINFO_SIZE_DOWNLOAD - 以字节为单位返回下载数据量的总值/size_download
	 * CURLINFO_HEADER_SIZE - header部分的大小/header_size
	 * 
	 * @param string $info
	 */
	public function catch_info(&$info){
		$this->onFinished(function($ch)use(&$info){
			$info=curl_getinfo($ch);
		});
	}
	/**
	 * 捕获响应HTTP状态码
	 * 最后一个收到的HTTP代码
	 * 404/403
	 * 302/301
	 * 
	 * @param string $http_code 传入一个存在的变量，以便引用。注意：必须是已定义变量
	 */
	public function catch_http_code(&$http_code){
		$this->onFinished(function($ch)use(&$http_code){
			$http_code=curl_getinfo($ch,CURLINFO_HTTP_CODE);
		});
	}
	/**
	 * 请求时间，连接时间
	 * 
	 * @param string $total_time
	 * @param string $connect_time
	 */
	public function catch_time(&$total_time,&$connect_time=null){
		$this->onFinished(function($ch)use(&$total_time,&$connect_time){
			$total_time=curl_getinfo($ch,CURLINFO_TOTAL_TIME);
			if($connect_time!==null){
				$connect_time=curl_getinfo($ch,CURLINFO_CONNECT_TIME);
			}
		});
	}
	/**
	 * 请求后事件
	 * 必须在请求前调用
	 * 
	 * @param \Closure $callback
	 */
	public function onFinished(\Closure $callback){
		$this->_onFinished=$callback;
	}
}
?>
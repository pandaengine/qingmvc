<?php
namespace qing\exception;
use qing\com\Component;
use qing\facades\Log;
use qing\http\Header;
use qing\mv\Alert;
use qing\mv\MV;
use qing\view\V;
use qing\exceptions\Exception as QException;
/**
 * 异常处理器
 * 
 * # 开发环境：
 * - APP_DEBUG=true
 * - 使用ExceptionHandler处理异常并打印debug信息
 * 
 * # 运行环境：
 * - APP_DEBUG=false
 * - 使用MessageHandler处理
 * - 只显示提示信息，debug等敏感信息需要屏蔽！！
 * - 
 * - HttpException 异常的消息根据httpcode显示简单信息
 * - Exception	       其他异常消息不可见
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ExceptionHandler extends Component{
	/**
	 * @var string 调度之前事件
	 */
	const E_EXCEP_BEFORE='excep.before';
	/**
	 * @var string 调度之后事件
	 */
	const E_EXCEP_AFTER='excep.after';
	/**
	 * qingmvc.php/2.0
	 * apache/php
	 * nginx/5.6
	 * 伪装较安全
	 * 
	 * @var bool 服务器信息
	 */
	public $serverInfo='nginx';
	/**
	 * 是否记录异常日志
	 *
	 * @var string
	 */
	public $logOn=true;
	/**
	 * 调试异常信息
	 * - 和APP_DEBUG联合确认是否显示调试信息
	 *
	 * @var string
	 */
	public $debug=false;
	/**
	 * 常用状态码 中文
	 *
	 * @var array
	 */
	public static $statusTexts=
	[
		// Success 2xx
		200=>'请求成功',
		// Redirection 3xx
		301=>'页面已永久转移',
		302=>'页面已找到',
		303=>'See Other',
		// Client Error 4xx
		400=>'错误请求',
		403=>'页面禁止访问',
		404=>'请求不存在',
		405=>'请求方式不允许',
		// Server Error 5xx
		500=>'服务器错误',
		503=>'服务不可用'
	];
	/**
	 */
	public function initComponent(){
	}
	/**
	 * 异常处理
	 * 
	 * @param \Exception|\Error|\Throwable $exception 异常对象
	 */
	public function handle(\Exception $exception){
		$inQing=$exception instanceof QException;
		$httpCode=0;
		$inQing && $httpCode=(int)$exception->httpCode;
		if($httpCode>0){
			//#Http异常,发送http报头
			Header::status($httpCode);
		}
		//#记录缓存日志
		if($this->logOn && $httpCode==0){
			//#http请求错误不记录
			$this->saveLog($exception,$httpCode);
		}
		//$debug=$this->debug && APP_DEBUG===true;
		$debug=$this->debug;
		//$debug=true;
		if(!$debug){
			//#生产模式
			//#清除php输出缓存
			$this->clearOutputBuffers();
			$this->runtimeHandler($exception);
		}else if(PHP_SAPI=='cli'){
			//#命令行模式
			$this->clearOutputBuffers();
			CliHandler::handle($exception);
		}else{
			//#debug模式
			//#转义输出缓存
			$this->escapeOutputBuffers();
			DebugHandler::handle($exception);
		}
	}
	/**
	 * 记录缓存日志
	 *
	 * @param \Exception $exception 异常对象
	 */
	protected function saveLog(\Exception $e,$httpCode){
		$msg=get_class($e).'('.$e->getCode().'): '.$e->getMessage().' FILE:'.$e->getFile().'('.$e->getLine().')';
		Log::error($msg,['cat'=>'excp']);
	}
	/**
	 * 开发环境的处理器
	 * 
	 * @param \Exception | \Error $exception
	 */
	protected function runtimeHandler(\Exception $exception){
		$inQing=$exception instanceof \qing\exceptions\Exception;
		$httpCode=0;
		$inQing && $httpCode=(int)$exception->httpCode;
		//
		$handler='';
		$message='';
		if($inQing){
			$handler=$exception->handler;
			$message=$exception->myMessage;//自定义可显示消息
		}
		//
		if(!$message){
			//可以显示的安全消息
			if($httpCode>0 && isset(self::$statusTexts[$httpCode])){
				//http消息
				$message=self::$statusTexts[$httpCode];
			}else{
				$message=L()->system_error;
			}
		}
		//
		if($handler=='alert'){
			//#alert处理器
			Alert::error($message);
		}else{
			//#view处理器，模块中自定义消息提示视图
			$mv=MV::error($message,[MV::autojump=>false]);
			if($mv){
				echo V::render($mv);
			}
		}
	}
	/**
	 * 转义输出缓存
	 * 
	 * ob_get_contents
	 * ob_get_clean
	 */
	protected function escapeOutputBuffers(){
		$content=ob_get_clean();
		if($content>''){
			$content=htmlentities($content);
			echo "\n<pre id='J-buffers' style='display:none;'>\n{$content}\n</pre>\n\n";
		}
	}
	/**
	 * 清除输出缓存
	 */
	protected function clearOutputBuffers(){
		for($level=ob_get_level();$level>0;--$level){
			if(!@ob_end_clean()){
				ob_clean();
			}
		}
	}
}
?>
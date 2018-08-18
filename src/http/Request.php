<?php
namespace qing\http;
use qing\com\Component;
use qing\utils\IP;
use qing\exceptions\http\NotFoundHttpException;
/**
 * http请求
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Request extends Component{
	/**
	 * @see \qing\com\Component::initComponent()
	 */
	public function initComponent(){
		
	}
	/**
	 * - 安全过滤&编码方式
	 * - $pathinfo=htmlentities($_SERVER['PATH_INFO'],ENT_QUOTES);
	 * - $value=htmlentities($value);
	 * - $value=urlencode($value);
	 * # get参数也可能是数组
	 * # "index.php?filter[typeid]=1&filter[username]=&filter[ip]=&filter[addtime_begin]=&filter[addtime_end]="
	 *
	 * @return string
	 */
	protected function safeFilter($value){
		return urlencode($value);
		//return f_safeText($value);
		//return htmlentities($value,ENT_QUOTES);
	}
	/**
	 * http请求方式|GET, POST, HEAD, PUT, DELETE.
	 */
	public function getMethod(){
		return strtoupper($_SERVER['REQUEST_METHOD']);
	}
	/**
	 * 是否是GET类型请求
	 * 
	 * @return boolean
	 */
	public function isGet(){
		return $this->getMethod()=='GET';
	}
	/**
	 * 是否是POST类型请求
	 * 
	 * @return boolean
	 */
	public function isPost(){
		return $this->getMethod()=='POST';
	}
	/**
	 * 判断是否是ajax请求
	 * #在jquery框架中，对于通过它的$.ajax, $.get, or $.post方法请求网页内容时，它会向服务器传递一个HTTP_X_REQUESTED_WITH的参数
	 * #可以自动添加参数
	 * 
	 * @return boolean
	 */
	public function isAjax(){
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){
			return true;
		}
		return false;
	}
	/**
	 *
	 * @return boolean
	 */
	public function onlyGet(){
		if(!$this->isGet()){
			//抛出异常
			$msg=L()->http_method_limit.' get';
			throw new NotFoundHttpException($msg);
		}
	}
	/**
	 *
	 * @return boolean
	 */
	public function onlyPost(){
		if(!$this->isPost()){
			//抛出异常
			$msg=L()->http_method_limit.' post';
			throw new NotFoundHttpException($msg);
		}
	}
	/**
	 * 获取用户输入数据
	 * get/post
	 * 严格模式，严格限制请求方式
	 *
	 * @return string
	 */
	public function input($key){
		if($this->isPost()){
			return isset($_POST[$key])?$_POST[$key]:null;
		}else{
			return isset($_GET[$key])?$_GET[$key]:null;
		}
	}
	/**
	 * 是否通过安全访问|https
	 * 
	 * @return boolean
	 */
	public function isSecure(){
		return $this->getScheme()=='HTTPS';
	}
	/**
	 * http/https
	 * 
	 * @see $_SERVER['REQUEST_SCHEME']
	 * @return string
	 */
	public function getScheme(){
		return strtolower($_SERVER['REQUEST_SCHEME']);
	}
	/**
	 * - http协议版本
	 * - HTTP/1.1
	 * - HTTP/1.0
	 * 
	 * @see $_SERVER['SERVER_PROTOCOL']
	 * @return string
	 */
	public function getProtocol(){
		return $_SERVER['SERVER_PROTOCOL'];
	}
	/**
	 * - $_SERVER['PATH_INFO']
	 * - index.php/login => /login|包括斜杠
	 * - 不安全的/XSS风险|/login<b>123</b>
	 * 
	 * ---------------------------------------------------------
	 * 获取pathinfo段,进行必要的安全过滤
	 * 会更改用户传入的数据
	 * 
	 * 安全过滤必须：2015.06.07
	 * /index.php/''""<b>123</b>/a/b/c\\/<?php echo '123';?>
	 * /test/(:any[name])
	 * /test/&lt;b&gt;HOHO&lt;  name=&lt;b&gt;HOHO&lt;
	 * ---------------------------------------------------------
	 * $pathinfo=htmlentities($_SERVER['PATH_INFO'],ENT_QUOTES);
	 * $value=urlencode($value);
	 * 
	 * @see $_SERVER['PATH_INFO']
	 * @param boolean $safe 是否执行安全过滤
	 * @return string
	 */
	public function getPathInfo($safe=false){
		$value=(string)@$_SERVER['PATH_INFO'];
		if(!$value){
			return '';
		}
		if($safe){
			$value=$this->safeFilter($value);
		}
		$value=trim($value,'/');
		return $value;
	}
	/**
	 * 不安全的/XSS风险|rootdir+phpfile+pathinfo|/public/test01.php/login<b>123</b>
	 * 
	 * @see $_SERVER['PHP_SELF']
	 * @param bool $safe 是否执行安全过滤
	 * @return string
	 */
	public function getPhpSelf($safe=false){
		$value=$_SERVER['PHP_SELF'];
		if($safe && $value>''){
			$value=$this->safeFilter($value);
		}
		return $value;
	}
	/**
	 * 请求域名|qingcms.com
	 * 
	 * @see $_SERVER['HTTP_HOST']
	 * @return string
	 */
	public function getHttpHost(){
		return $_SERVER['HTTP_HOST'];
	}
	/**
	 * @see getHttpHost()
	 */
	public function getHost(){
		return $this->getHttpHost();
	}
	/**
	 * 用户代理|用户可以伪造
	 * 
	 * @see $_SERVER['HTTP_USER_AGENT']
	 * @return string
	 */
	public function getUserAgent(){
		$value=$_SERVER['HTTP_USER_AGENT'];
		return $value;
	}
	/**
	 * - 请求uri|已经过安全编码
	 * - rootdir+phpfile+pathinfo+querystring|
	 * - /public/test01.php/login%3Cb%3E123%3C/b%3E?name=xiaowang
	 * 
	 * @see $_SERVER['REQUEST_URI']已经安全编码
	 * @return string
	 */
	public function getRequestUri(){
		return $_SERVER['REQUEST_URI'];
	}
	/**
	 * http请求时间
	 *
	 * @see $_SERVER['REQUEST_TIME']
	 * @see $_SERVER['REQUEST_TIME_FLOAT']
	 * @return string
	 */
	public function getRequestTime(){
		return $_SERVER['REQUEST_TIME'];
	}
	/**
	 * 请求的PHP脚本文件
	 * /qingmvc/public/admin.php
	 *
	 * @see $_SERVER['SCRIPT_NAME']
	 * @return string
	 */
	public function getScriptName(){
		return $_SERVER['SCRIPT_NAME'];
	}
	/**
	 * 脚本名称
	 * admin.php
	 * 
	 * 请求的PHP脚本文件|rootdir+phpfile|/public/index.php
	 * 2015.05.20:只显示文件名|index.php/user.php
	 * 
	 * @see $_SERVER['SCRIPT_NAME']
	 * @return string
	 */
	public function getScriptBasename(){
		return basename($_SERVER['SCRIPT_NAME']);
	}
	/**
	 * - 网站根目录
	 * - 根路径rootpath=rootdir|不包括php脚本
	 * - SCRIPT_NAME: /public/index.php | /public
	 * - 总是安全的|跟访问的脚本文件相关
	 * - \ / DS 则为空
	 * 
	 * @see $_SERVER['SCRIPT_NAME']
	 * @return string
	 */
	public function getRootpath(){
		return dirname($_SERVER['SCRIPT_NAME']);
	}
	/**
	 * 客户端请求ip
	 * 
	 * @return string
	 */
	public function getClientIp(){
		return IP::client();		
	}
	/**
	 * 取得请求来源地址|只有a链接请求会带上referer
	 * 可以做到防盗链作用，只有点击超链接（即<A href=...>） 打开的页面才有HTTP_REFERER环境变量
	 * 其它如直接访问| window.open()等打开的窗口都没有HTTP_REFERER 环境变量
	 *
	 * - 安全性：编码？用户修改XSS
	 * - 已经urlencode|已经足够|已经解决XSS|使用字符串已足够
	 * - 要提取或解码了数据则需要安全过滤|safeFilter
	 *
	 * @see $_SERVER['HTTP_REFERER']
	 * @return string
	 */
	public function getReferer($safe=true){
		$value=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
		if($safe && $value>''){
			$value=$this->safeFilter($value);
		}
		return $value;
	}
	/**
	 * # url中的查询字符串
	 * 
	 * @xss
	 * @see $_SERVER['QUERY_STRING'] | $_GET;
	 * @return string
	 */
	public function getQueryString(){
		return $_SERVER['QUERY_STRING'];
	}
}
?>
/**
 * 构造函数
 * 
 * 设置cookie值|setcookie() 函数向客户端发送一个 HTTPcookie
 * ----------------------------------------------------------
 * 登录
 * 用户登陆成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
 * setcookie('Example_auth', uc_authcode($uid."\t".$userkey, 'ENCODE'),time()+3600*24,'/_test2/ucenter/demo01');
 * ----------------------------------------------------------
 * setcookie(key,value,expire,path,domain,secure)
 *
 *
 * @param string $key		 cookie 的名称
 * @param string $value		 cookie 的值
 * @param int    $expire	 cookie 的有效期/1h:1*3600/24h:24*3600
 * @param string $path		 cookie 的服务器路径|/|/public
 * @param string $domain	 cookie 的域名|example.com
 * @param bool   $secure	   规定是否通过安全的 HTTPS 连接来传输 cookie|1/0
 * @param bool   $httponly
 */
public function __construct_OFF($key,$value=null,$expire=0,$path='/',$domain=null,$secure=false,$httpOnly=true){
	$this->key 	= $key;
	$this->value 	= $value;
	$this->domain 	= $domain;
	$this->expire 	= $expire;
	$this->path 	= $path?$path:'/';
	$this->secure 	= (bool)$secure;
	$this->httpOnly = (bool)$httpOnly;
}

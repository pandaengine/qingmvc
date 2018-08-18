
```
/**
 * unset($_SESSION);
 * 销毁session变量
 * ---
 * unset($_SESSION)内存中的变量被删除 ，但保存有会话信息的数据并未被删除
 * 刷新之后$_SESSION仍有数据
 */
public function session_unset(){
	//unset($_SESSION);
	session_unset();
}
/**
 * 销毁Session|删除服务器文件
 * ---
 * 如果只是调用session_destroy();
 * 那么echo $_SESSION['user']依然是有值的
 * 即内存中的$_SESSION变量内容依然保留
 * ---
 * session_destroy 删除保存有会话信息的数据文件，未刷新前 $_SESSION['user']依然是有值。
 * 刷新之后，由于会话数据已经被删除，session_start后 $_SESSION 仍为空
 * ---
 * - destroy cookie过期，仍可指定cookie使用对应session
 * - session文件的删除，有gc定期清理
 */
public function session_destroy(){
	session_destroy();
}
/**
 * - 更新session标志
 * - 在不修改当前会话中数据的前提下使用新的 ID，替换原有会话 ID。
 */
public function session_regenerate_id(){
	session_regenerate_id();
}
/**
 * 用文件保存session时的保存目录
 * 读取/设置当前会话的保存路径
 * 
 * @tip 必须在调用 session_start() 函数之前调用 session_save_path() 函数。
 * @link http://php.net/manual/zh/function.session-save-path.php
 * @param string $path
 */
public function setSavePath($path){
	session_save_path($path);
}
/**
 * @see SessionConfigTrait
 * @param \SessionHandlerInterface $sessionhandler
 * @param string $register_shutdown
 */
public function setSaveHandler(\SessionHandlerInterface $sessionhandler,$register_shutdown=true){
	session_set_save_handler($sessionhandler,$register_shutdown);
}
/**
 * 设置会话过期时间，单位秒/s；60*60*24=24h
 * 过期后session文件和cookie均被清除
 * ---
 * session.gc_maxlifetime ：默认1440s/24min/指定过了多少秒之后数据就会被视为'垃圾'并被清除。
 * session.cookie_lifetime：cookie过期时间
 * ---
 * 会覆盖$session_cookie_lifetime配置
 *
 * ---
 * # 设置session生命周期
 * # 执行回收器gc的生命周期
 *
 * - session过期事件
 * - session.gc_maxlifetime:
 * - 和session.gc_probability/session.gc_divisor概率有关，
 * - 例如 1/100 意味着在每个请求中有 1% 的概率启动 gc进程。
 * ---
 * 设置会话cookie过期时间；会覆盖$session_cookie[0]；60*60*24=24h
 *
 * session.cookie_lifetime
 * 以秒数指定了发送到浏览器的 cookie的生命周期；值为 0 表示'直到关闭浏览器'；默认为 0。
 *
 * @link http://php.net/manual/zh/session.configuration.php#ini.session.gc-maxlifetime
 * @param number $lifetime
 */
public function setLifetime($lifetime){
	//#回收机制周期
	ini_set('session.gc_maxlifetime',$lifetime);
	//cookie过期时间
	//ini_set('session.cookie_lifetime',$lifetime);
	$this->setCookieLifetime($lifetime);
}
/**
 * session_set_cookie_params:
 * Cookie 参数可以在 php.ini 文件中定义，本函数仅在当前脚本执行过程中有效。
 * 因此，如果要通过函数修改 cookie 参数，需要对每个请求都要 在调用 session_start() 函数之前调用 session_set_cookie_params() 函数。
 * 本函数会修改运行期 ini 设置值， 可以通过 ini_get() 函数获取这些值。
 * ---
 * session.cookie_lifetime : 以秒数指定了发送到浏览器的 cookie 的生命周期。值为 0 表示“直到关闭浏览器”。默认为 0。
 *
 * @param number $lifetime=0
 */
public function setCookieLifetime($lifetime){
	ini_set('session.cookie_lifetime',$lifetime);
}
/**
 * session.cookie_path 指定了要设定会话 cookie 的路径。默认为 /
 * ini_set必须在session_start前设置
 * 
 * @param string $path='/'
 */
public function setCookiePath($path){
	ini_set('session.cookie_path',$path);
}
/**
 * session.cookie_domain 指定了要设定会话 cookie 的域名。
 * 默认为无，表示根据 cookie 规范产生 cookie 的主机名。
 *
 * @param string $domain=''
 */
public function setCookieDomain($domain){
	ini_set('session.cookie_domain',$domain);
}
/**
 * - 只能通过 http 协议访问 cookie，不能通过脚本语言（如JavaScript）访问。
 * - 此设置可以有效地帮助通过XSS攻击减少身份盗窃（尽管它不受所有浏览器的支持）。
 * - 设置为 TRUE 表示 PHP 发送 cookie 的时候会使用 httponly 标记。
 *
 * session.cookie_httponly boolean
 * Marks the cookie as accessible only through the HTTP protocol.
 * This means that the cookie won't be accessible by scripting languages, such as JavaScript.
 * This setting can effectively help to reduce identity theft through XSS attacks
 * (although it is not supported by all browsers).
 *
 * @param boolean $httponly
 */
public function setCookieHttpOnly($httponly=true){
	ini_set('session.cookie_httponly',$httponly);
}
```

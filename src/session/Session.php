<?php 
namespace qing\session;
use qing\com\Component;
/**
 * Session组件
 * 
 * # 序列化数据
 * ~runtime\~sess\sess_0j9da9362dcam20ueqgq6idnc6|a|s:3:"aaa";b|s:3:"bbb";
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Session extends Component{
	/**
	 * session标识符/默认PHPSESSID
	 * 
	 * @var string
	 */
	public $session_name;
	/**
	 * 会话cookie的httponly标识符
	 * 
	 * @var boolean 默认开启
	 */
	public $cookie_httponly=true;
	/**
	 * 会话生命周期
	 * 
	 * - 会话文件回收周期，受gc启动概率影响，不精确
	 * - 会话cookie过期时间，精确删除，但是通过伪造请求, 还是可以使用这个SessionID的值
	 * - 
	 * 
	 * @var number
	 */
	public $lifetime;
	/**
	 * @see \qing\com\Component::initComponent()
	 */
	public function initComponent(){
		
	}
	/**
	 * 自动启动
	 * 
	 * @tip 注意许多设置需要在session_start之前设置才生效，特别是ini_set
	 */
	public function autostart(){
		//关闭自动启动
		ini_set('session.auto_start',0);
		$this->start();
	}
	/**
	 * 启动session
	 * 配置session要在调用session_start前才有效
	 */
	public function start(){
		//关闭自动启动
		ini_set('session.auto_start',0);
		//
		if($this->session_name){
			$this->session_name($this->session_name);
		}
		//开启httponly，防范xss，避免sessionid泄漏
		$this->cookie_httponly($this->cookie_httponly);
		//
		if($this->lifetime!==null){
			$this->lifetime($this->lifetime);
		}
		//需要设置完成后才能启动
		session_start();
		//
		/*
		if($this->lifetime!==null){
			$this->lifetime_check($this->lifetime);
		}
		*/
	}
	/**
	 * 设置会话过期时间，单位秒/s；60*60*24=24h
	 * 过期后session文件和cookie均被清除
	 * ---
	 * session.gc_maxlifetime ：默认1440s/24min/指定过了多少秒之后数据就会被视为'垃圾'并被清除。
	 * session.cookie_lifetime：cookie过期时间
	 * ---
	 * # 会话文件回收机制（gc）周期
	 *
	 * - session.gc_maxlifetime:
	 * - 和session.gc_probability/session.gc_divisor概率有关，
	 * - 例如 1/100 意味着在每个请求中有 1% 的概率启动 gc进程。
	 *
	 * @param number $lifetime
	 */
	public function lifetime($lifetime=0){
		//会话文件回收机制周期，受到gc进程启动概率影响
		ini_set('session.gc_maxlifetime',$lifetime);
		//cookie过期时间
		$this->cookie_lifetime($lifetime);
	}
	/**
	 * 生命周期，精确检测
	 * 
	 * @param number $lifetime 大于0才有效
	 */
	public function lifetime_check($lifetime){
		if(0==(int)$lifetime){return;}
		if(isset($_SESSION['q_lifetime']) && (time()-$_SESSION['q_lifetime'])>$lifetime ){
			//会话过期,销毁会话
			$this->destroy();
		}else{
			//每次访问都更新时间
			$_SESSION['q_lifetime']=time();
		}
	}
	/**
	 * 保持会话活跃
	 * 
	 * 如果每次访问，只读取会话文件，没有修改，会导致会话文件修改时间不更新，很快过期
	 * 回收机制会认为这是一个长时间没有活跃的session而将其删除，会话被过早终结
	 * 
	 * - session_start()之后再调用
	 * - 没有设置生命周期，则没有必要
	 * 
	 * @param number $lifetime
	 */
	public function keepalive(){
		if($this->lifetime!=null){
			//设置了生命周期
			if(!isset($_SESSION['q_keepalive']) || (time()-$_SESSION['q_keepalive'])>=$this->lifetime){
				$_SESSION['q_keepalive']=time();
			}
		}
	}
	/**
	 * 垃圾回收管理器(GC)进程的启动概率
	 * 
	 * 此概率用 gc_probability/gc_divisor计算得来，例如 1/100 意味着在每个请求中有 1% 的概率启动 gc进程
	 * 
	 * - 根据会话数据文件的修改时间来确认是否过期
	 * - 如果每次访问，只读取会话文件，没有修改，会导致会话文件修改时间不更新，会话被过早终结
	 * 
	 * @param number $gc_probability 默认为 1
	 * @param number $gc_divisor 默认为 100
	 */
	public function gc_probability($gc_probability,$gc_divisor){
		ini_set('session.gc_probability',$gc_probability);
		ini_set('session.gc_divisor',$gc_divisor);
	}
	/**
	 * 自定义会话管理处理器
	 * 
	 * @param \SessionHandlerInterface $sessionhandler
	 * @param boolean $register_shutdown
	 */
	public function save_handler(\SessionHandlerInterface $sessionhandler,$register_shutdown=true){
		session_set_save_handler($sessionhandler,$register_shutdown);
	}
	/**
	 * 获取session的值
	 * 
	 * @param string $key
	 */
	public function get($key){
		return @$_SESSION[$key];
	}
	/**
	 * 设置session的值
	 * 
	 * - 即时提交，关闭文件占用，避免文件锁阻塞
	 * - 只要读取数据产生$_SESSION即可关闭文件
	 * 
	 * @param string $key
	 * @param string $value
	 * @param boolean $commit 是否要提交
	 */
	public function set($key,$value,$commit=false){
		$_SESSION[$key]=$value;
		if($commit){
			$this->commit();
		}
	}
	/**
	 * 批量设置session的值
	 * 
	 * @param array  $values	数据数组
	 * @param bool   $commit	是否要提交
	 */
	public function sets(array $values,$commit=false){
		foreach($values as $key=>$value){
			$_SESSION[$key]=$value;
		}
		if($commit){
			$this->commit();
		}
	}
	/**
	 * @param string $key
	 */
	public function remove($key){
		if(isset($_SESSION[$key])){
			unset($_SESSION[$key]);
		}
	}
	/**
	 * @param string $key
	 */
	public function has($key){
		return isset($_SESSION[$key]);
	}
	/**
	 * 保存会话数据并释放文件锁。避免文件锁阻塞
	 * 同一个用户，使用同一个会话id,使用同一个会话文件，会引起阻塞！
	 * ---
	 * 手动提交关闭session/避免session文件锁阻塞
	 * close|commit
	 * ---
	 * 把变量$_SESSION中的数据写入保存session数据（持久化）并关闭session
	 * session_commit()是session_write_close()别名
	 */
	public function commit(){
		//session_commit();
		session_write_close();
	}
	/**
	 * 立即完全销毁Session
	 * ---
	 * 如果只是调用session_destroy();
	 * 那么echo $_SESSION['user']依然是有值的
	 * 即内存中的$_SESSION变量内容依然保留
	 * ---
	 * session_destroy 删除保存有会话信息的数据文件，未刷新前 $_SESSION['user']依然是有值。
	 * 刷新之后，由于会话数据已经被删除，session_start后 $_SESSION 仍为空
	 * ---
	 * unset($_SESSION)  内存中的变量被删除 ，但会话数据文件并未被删除
	 * 刷新之后$_SESSION仍有数据
	 * ---
	 * 立即销毁会话和会话变量需要   unset($_SESSION); session_destroy();
	 * ---
	 * $_SESSION=[],会话数据为空，commit之后应用到会话数据，会话数据也为空
	 */
	public function destroy(){
		if($_SESSION){ $_SESSION=[]; }
		session_unset();
		session_destroy();
	}
	/**
	 * 读取/设置会话名称
	 * 
	 * @param string $name PHPSESSID/sessid
	 * @return string
	 */
	public function session_name($name=''){
		if($name>''){
			session_name($name);
			return true;
		}else{
			return session_name();
		}
	}
	/**
	 * 重新生成会话ID
	 * 
	 * - 不修改会话数据,使用新的 ID，替换原有会话 ID
	 * - 避免id被劫持
	 * 
	 * re generate 重新生成
	 */
	public function regenerate_id(){
		session_regenerate_id();
	}
	/**
	 * 用文件保存session时的保存目录
	 * 读取/设置当前会话的保存路径
	 *
	 * @see session.save_path string
	 * @param string $path
	 */
	public function save_path($path=''){
		return $path>''?session_save_path($path):session_save_path();
	}
	/**
	 * 会话cookie的生命周期，以秒为单位
	 * - 以秒数指定了发送到浏览器的 cookie 的生命周期
	 * - 值为 0 表示“直到关闭浏览器”。默认为 0。
	 * 
	 * 注意：
	 * - 客户端cookie控制会话生命周期 ，cookie失效，不再发送，session_start会返回新的sessionid.cookie
	 * - 但是通过伪造请求, 还是可以使用这个SessionID的值
	 * 
	 * @see session.cookie_lifetime integer
	 * @param number $lifetime=0
	 */
	public function cookie_lifetime($lifetime=0){
		ini_set('session.cookie_lifetime',$lifetime);
	}
	/**
	 * 会话 cookie的路径，默认为 /
	 *
	 * @see session.cookie_path string
	 * @param string $path '/'
	 */
	public function cookie_path($path='/'){
		ini_set('session.cookie_path',$path);
	}
	/**
	 * 会话 cookie 的域名
	 * - 默认为无，自动产生主机名。
	 * - 如果要让 cookie在所有的子域中都可用，此参数必须以点（.）开头，例如：.qingmvc.com
	 * 
	 * @see session.cookie_domain string
	 * @param string $domain
	 */
	public function cookie_domain($domain=null){
		ini_set('session.cookie_domain',$domain);
	}
	/**
	 * 仅通过安全连接(https)发送 cookie，默认为 off
	 *
	 * @see session.cookie_secure boolean
	 * @param boolean $secure
	 */
	public function cookie_secure($secure=true){
		ini_set('session.cookie_secure',$secure);
	}
	/**
	 * - 只能通过 http 协议访问 cookie，不能通过脚本语言（如JavaScript）访问。
	 * - 此设置可以有效地帮助通过XSS攻击减少身份盗窃（尽管它不受所有浏览器的支持）。
	 * - 设置为 TRUE 表示 PHP 发送 cookie 的时候会使用 httponly 标记。
	 *
	 * @see session.cookie_httponly boolean
	 * @param boolean $httponly
	 */
	public function cookie_httponly($httponly=true){
		ini_set('session.cookie_httponly',$httponly);
	}
	/**
	 * 打印session.cookie_* 配置信息
	 */
	public function printCookie(){
		dump(session_get_cookie_params());
	}
	/**
	 * 是否开启url传递sessionid
	 * 
	 * @deprecated 基于 URL的会话管理比基于 cookie的会话管理有更多安全风险
	 * @see session.use_trans_sid boolean
	 * @param number $use
	 */
	public function use_trans_sid($use=0){
		ini_set('session.use_trans_sid',$use);
	}
}
?>
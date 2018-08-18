<?php 
namespace qing\session;
/**
 * Cookie
 * 

send_cookie('test',time())->set24hrs()->domain('.qingmvc.com')->send();
- 查看响应报头：
Set-Cookie:test=1463385609; 
expires=Tue, 17-May-2016 08:00:09 GMT; 
Max-Age=86400; path=/; domain=.qingmvc.com; httponly

 * 
 * @link QingMVC [ QING IS NOT SIMPLE ]
 * @see RFC6265 setcookie
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Cookie{
	/**
	 * cookie名称
	 * 
	 * @var string 
	 */
	public $key;
	/**
	 * cookie值
	 * 
	 * @var string
	 */
	public $value='';
	/**
	 * - 过期的时间,Unix时间戳
	 * - 默认为0：直到浏览器关闭
	 * - 24小时过期：time()+24*3600
	 * 
	 * @var integer 0
	 */
	public $expire=null;
	/**
	 * cookie有效的网站目录路径
	 * 
	 * @var string '/'
	 */
	public $path=null;
	/**
	 * cookie有效的域名
	 * 
	 * - qingmvc.com : 整个域名有效
	 * - .qingmvc.com : 废弃的RFC2109标准
	 * 
	 * @var string ''
	 */
	public $domain=null;
	/**
	 * 仅仅通过安全的 HTTPS 连接传给客户端
	 * 
	 * @var boolean
	 */
	public $secure=null;
	/**
	 * - Cookie仅可通过 HTTP 协议访问
	 * - 不能通过js脚本访问
	 * - 可以有效减少XSS 攻击时的身份窃取行为
	 * 
	 * @var boolean
	 */
	public $httponly=null;
	/**
	 * 构造函数
	 *
	 * @param string $key	cookie 的名称
	 * @param string $value	cookie 的值
	 */
	public function __construct($key,$value){
		$this->key =$key;
		$this->value=$value;
	}
	/**
	 * 有效期（单位：分钟）
	 *
	 * @return $this
	 */
	public function e_mins($mins){
		$expire=time()+(int)$mins*60;
		return $this->expire($expire);
	}
	/**
	 * 有效期（单位：小时）
	 *
	 * @return $this
	 */
	public function e_hours($hours){
		$expire=time()+(int)$hours*3600;
		return $this->expire($expire);
	}
	/**
	 * 有效期24小时
	 *
	 * @return $this
	 */
	public function e_24hours(){
		return $this->e_hours(24);
	}
	/**
	 * @return $this
	 */
	public function expire($expire){
		$this->expire=$expire;
		return $this;
	}
	/**
	 * @param string $path
	 * @return $this
	 */
	public function path($path){
		$this->path=$path;
		return $this;
	}
	/**
	 * @param string $domain
	 * @return $this
	 */
	public function domain($domain){
		$this->domain=$domain;
		return $this;
	}
	/**
	 * @param string $secure
	 * @return $this
	 */
	public function secure($secure){
		$this->secure=$secure;
		return $this;
	}
	/**
	 * @param string $httponly
	 * @return $this
	 */
	public function httponly($httponly){
		$this->httponly=$httponly;
		return $this;
	}
	/**
	 * 删除cookie
	 * 要删除一个 Cookie，应该设置过期时间为过去，以触发浏览器的删除机制。
	 * 
	 * @deprecated
	 * @see CookieX::remove()
	 */
	public function remove(){
		setcookie($this->key,'',time()-24*3600);
	}
	/**
	 * 向客户端发送cookie
	 * 
	 * #NULL时，使用默认值
	 * function setcookie ($name, $value = null, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null) {}
	 */
	public function send(){
		setcookie($this->key,$this->value,$this->expire,$this->path,$this->domain,$this->secure,$this->httponly);
	}
}
?>
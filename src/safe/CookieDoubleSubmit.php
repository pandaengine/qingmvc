<?php 
namespace qing\safe;
use qing\session\Cookie;
use qing\utils\Instance;
/**
 * cookie双提交验证
 * csrf令牌验证
 * 
 * - 验证post/get提交的id和cookie携带的id
 * - 需要js获取cookie.csrf的能力，填充到post/get参数
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CookieDoubleSubmit{
	/**
	 * @return CookieDoubleSubmit
	 */
	public static function sgt(){
		return Instance::sgt(__CLASS__);
	}
	/**
	 * 令牌参数是get还是post
	 * 
	 * @var bool
	 */
	public $isPost=true;
	/**
	 *
	 * @var bool
	 */
	public $tokenKey='csrfid';
	/**
	 * cookie有效的网站目录路径
	 *
	 * @var string
	 */
	public $cookie_path='/';
	/**
	 * cookie有效的域名
	 *
	 * @var string
	 */
	public $cookie_domain=null;
	/**
	 * - 过期的时间|单位分钟
	 *
	 * @var integer
	 */
	public $cookie_mins=30;
	/**
	 * 请求参数
	 * 
	 * @return string
	 */
	protected function getParamToken(){
		if($this->isPost){
			return (string)@$_POST[$this->tokenKey];
		}else{
			return (string)@$_GET[$this->tokenKey];
		}
	}
	/**
	 * 请求cookie
	 * 
	 * @return string
	 */
	protected function getCookieToken(){
		return (string)@$_COOKIE[$this->tokenKey];
	}
	/**
	 * @param boolean $is
	 * @return$this
	 */
	public function ispost($is=true){
		$this->isPost=(bool)$is;
		return $this;
	}
	/**
	 * 验证权限
	 */
	public function auth(){
		$param =$this->getParamToken();
		$cookie=$this->getCookieToken();
		if($cookie>'' && $cookie==$param){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 更新cookie
	 * 手动调用
	 */
	public function update(){
		$value=self::createToken();
		(new Cookie($this->tokenKey,$value))
		->domain($this->cookie_domain)
		->path($this->cookie_path)
		->e_mins($this->cookie_mins)
		->send();
	}
	/**
	 * 创建令牌
	 */
	public static function createToken(){
		return md5(uniqid(microtime(true),true));
	}
}
?>
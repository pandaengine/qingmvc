<?php 
namespace qing\safe;
use qing\session\Cookie;
/**
 * cookie双提交验证
 * csrf令牌验证
 * 简单功能，配置量少，使用静态函数，不需要使用组件
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
	 * 令牌数据保存到session的的一个数组
	 * 分类，容易识别，避免覆盖
	 * $_SESSION{'_form_token_':{'form1':'123','form2':'456'}}
	 *
	 * @var string
	 */
	public static $tokenKey='csrfid';
	/**
	 * 验证令牌合法性
	 * 
	 * @param boolean $ispost
	 * @return boolean
	 */
	public static function auth($ispost=false){
		$param =self::getParamToken($ispost);
		$cookie=self::getCookieToken();
		if($cookie>'' && $cookie==$param){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 更新令牌或初始化令牌
	 *
	 * @name init
	 * @param string $domain cookie域名
	 * @param string $expire cookie过期日期
	 */
	public static function update($domain=null,$expire=null){
		$value=md5(uniqid(microtime(true),true));
		//
		(new Cookie(self::$tokenKey,$value))
		->domain($domain)
		->expire($expire)
		->send();
	}
	/**
	 * 创建令牌
	 */
	public static function createToken(){
		return md5(uniqid(microtime(true),true));
	}
	/**
	 * 获取参数令牌
	 * get/post提交的令牌
	 * 
	 * @return string
	 */
	public static function getParamToken($ispost){
		if($ispost){
			return (string)@$_POST[self::$tokenKey];
		}else{
			return (string)@$_GET[self::$tokenKey];
		}
	}
	/**
	 * 获取cookie提交的令牌
	 * 
	 * @return string
	 */
	public static function getCookieToken(){
		return (string)@$_COOKIE[self::$tokenKey];
	}
}
?>
<?php 
namespace qing\safe;
/**
 * 表单令牌组件
 * - 为了解决@CSRF跨站请求伪造
 * - 如果有验证码等验证时，不需要表单令牌
 * - 简单功能，配置量少，使用静态函数，不需要使用组件
 * 
 * # 令牌总是要多次使用
 * - ajax:多次提交不刷新，不重新生成令牌,其他验证信息，都可能多次提交验证
 * - ajax:不管令牌验证成功与否，令牌应该保持不变，否则不能多次提交
 * - 普通页面:令牌刷新一次更新一次
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FormToken{
	/**
	 * 令牌数据保存到session的的一个数组
	 * 分类，容易识别，避免覆盖 
	 * $_SESSION{'_form_token_':{'form1':'123','form2':'456'}}
	 *
	 * @var string
	 */
	public static $tokenKey='_form_token_';
	/**
	 * 令牌验证失败则重置令牌
	 * - 重置令牌需要刷新页面才能恢复正常
	 * - 避免不断尝试破解令牌?
	 *
	 * @deprecated 尝试破解令牌，得不偿失，不需要考虑
	 * @var string
	 */
	//public static $failReset=true;
	/**
	 * 生成令牌值
	 *
	 * @param string  $formId	   表单ID,不同的表单生成的hash值不一样|否则session值被覆盖
	 * @return string
	 */
	public static function create($formId){
		$value=self::createValue($formId);
		return "<input type='hidden' name='{$formId}' value='{$value}' />";
	}
	/**
	* 手动更新令牌值
	*
	* @param string  $formId
	* @return string
	*/
	public static function update($formId){
		return self::createValue($formId);
	}
	/**
	 * 验证令牌
	 * - 成功：令牌验证成功，才可以验证其他信息，需要多次提交
	 * - 失败：可以不刷新，
	 * 
	 * @param string $value  前端传入要验证的值
	 * @param string $formId 验证的表单ID，可以为空
	 */
	public static function check($value,$formId=''){
		$token=self::getValue($formId);
		if(!$token || $token!=$value){
			return false;
		}else{
			return true;
		}
	}
	/**
	 * 创建一个令牌的hash值
	 * $_SESSION每个用户都拥有一个独立的值
	 * 
	 * @param string $formId 表单ID
	 */
	public static function createValue($formId){
		$value=md5(uniqid($formId,true));
		return $_SESSION[self::$tokenKey][$formId]=$value;
	}
	/**
	 * 获取令牌值
	 * 
	 * @param string $formId
	 */
	public static function getValue($formId){
		if(isset($_SESSION[self::$tokenKey][$formId])){
			return $_SESSION[self::$tokenKey][$formId];
		}else{
			return '';
		}
	}
}
?>
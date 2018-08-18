<?php
namespace qing\validator;
/**
 * 安全字符验证器
 * 
 * - abc|仅字母
 * - abc123|仅字母数字
 * - zhabc123|仅汉字字母数字|不包括逗号问号空格等字符？？
 *
 * @name Word
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SafeChar{
	/**
	 * 只返回字母（大写 小写）和数字和下划线和附加字符
	 *
	 * - 匹配非abc123	|/[^a-zA-Z0-9'.$plus.']/
	 * - 匹配abc123	|/^[a-zA-Z0-9'.$plus.']*$/
	 * - 从头到尾匹配：/^[a-zA-Z0-9]*$/
	 *
	 * @param string $value 要过滤的值
	 * @param string $plus
	 * @return mixed
	 */
	public static function abc123($value,$plus=''){
		$plus	=Validator::quote($plus);
		$pattern='/[^a-zA-Z0-9'.$plus.']/';//排除法，匹配到非法字符则失败，否则成功
		return preg_match($pattern,$value)==0;
	}
	/**
	 * 只返回中文|/u十六进制？
	 * 从头到尾匹配：/[^\x{4e00}-\x{9fa5}'.$plus.']/u
	 * 
	 * @param string $value 要过滤的值
	 * @param string $plus
	 * @return string
	 */
	public static function zh($value,$plus=''){
		$plus	=Validator::quote($plus);
		$pattern='/[^\x{4e00}-\x{9fa5}'.$plus.']/u';
		return preg_match($pattern,$value)==0;
	}
	/**
	 * 过滤|只返回中文/字母/数字
	 *
	 * 白名单:'/^[\x{4e00}-\x{9fa5}a-z0-9'.$plus.']$/ui';
	 * 黑名单:排除法
	 *
	 * @param string $value 要过滤的值
	 * @param string $plus
	 */
	public static function zhabc123($value,$plus=''){
		$plus	=Validator::quote($plus);
		$pattern='/[^\x{4e00}-\x{9fa5}a-z0-9'.$plus.']/ui';
		return preg_match($pattern,$value)==0;
	}
}
?>
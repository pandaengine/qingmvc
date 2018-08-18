<?php
namespace qing\validator\filter;
/**
 * 安全字符过滤器
 * 
 * - abc|仅字母
 * - abc123|仅字母数字
 * - zhabc123|仅汉字字母数字|不包括逗号问号空格等字符？？
 * - 不允许特殊符号：引号、斜杠 等危险字符
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SafeChar{
	/**
	 * 只返回字母（大写 小写）和数字和下划线和附加字符
	 *
	 * @param string $value
	 * @param string $plus
	 * @return mixed
	 */
	public static function abc123($value,$plus=''){
		$plus	=Filter::quote($plus);
		$pattern='/[^a-zA-Z0-9'.$plus.']/';//排除法，清除非字母数字字符
		return preg_replace($pattern,'',$value);
	}
	/**
	 * 只返回中文
	 * \x 十六进制？
	 * /u utf8
	 * 
	 * # u (PCRE_UTF8)
	 * 此修正符打开一个与 perl 不兼容的附加功能。 
	 * 模式和目标字符串都被认为是 utf-8 的。 
	 *
	 * @param string $value
	 * @param string $plus
	 * @return string
	 */
	public static function zh($value,$plus=''){
		$plus	=Filter::quote($plus);
		$pattern='/[^\x{4e00}-\x{9fa5}'.$plus.']/u';
		return preg_replace($pattern,'',$value);
	}
	/**
	 * 过滤|只返回中文/字母/数字
	 *
	 * @param string $value
	 * @param string $plus
	 */
	public static function zhabc123($value,$plus=''){
		$plus	=Filter::quote($plus);
		$pattern='/[^\x{4e00}-\x{9fa5}a-z0-9'.$plus.']/ui';
		return preg_replace($pattern,'',$value);
	}
}
?>
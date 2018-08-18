<?php 
namespace qing\str;
/**
 * 字符个数，不考虑占用字节
 * Character count
 * 字符个数，中文/字母/数字均只占一个字符
 * 
 * - iconv: 系统默认激活扩展
 * - mb_string: 默认未激活扩展，不过更加稳定？
 * 
 * @notice 和占用字节数不同无关
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */
class Chars{
	/**
	 * 字符个数
	 * 
	 * iconv_strlen要转换编码时，不稳定，但包含中文时不稳定
	 * iconv_strlen(): Detected an illegal character in input string
	 * 
	 * @param string $string
	 * @param string $charset 编码/utf-8/gb2312/gbk/big5
	 * @return number
	 */
	public static function num($string,$charset=''){
		if(!$charset){
			if(function_exists('iconv_strlen')){
				//iconv默认开启
				return iconv_strlen($string);
			}else if(function_exists("mb_strlen")){
				//mb_string要手动开启
				return mb_strlen($string);
			}
		}else{
			if(function_exists("mb_strlen")){
				//mb_string要手动开启
				return mb_strlen($string,$charset);
			}else if(function_exists('iconv_strlen')){
				//iconv默认开启
				return iconv_strlen($string,$charset);
			}
		}
		throw new \Exception('不支持获取字符个数');
	}
	/**
	 * 按字符分割
	 * 分割字符串，字符串子串
	 * 截取字符串，全角半角都占设置长度的一位；支持中文，不会有乱码
	 *
	 * 分割字符，能正确分割中文，不会乱码
	 * 字符个数，中文/字母/数字均只占一个字符
	 *
	 * @param string $value
	 * @param number $start
	 * @param number $length 使用的最大字符数。如果省略了此参数或者传入了 NULL，则会提取到字符串的尾部。
	 * @param string $charset utf-8
	 */
	public static function sub($value,$start,$length=null,$charset=''){
		if(!$charset){
			if(function_exists('iconv_substr')){
				return iconv_substr($value,$start,$length);
			}else if(function_exists("mb_substr")){
				return mb_substr($value,$start,$length);
			}
		}else{
			if(function_exists("mb_substr")){
				return mb_substr($value,$start,$length,$charset);
			}else if(function_exists('iconv_substr')){
				return iconv_substr($value,$start,$length,$charset);
			} 
		}
		throw new \Exception('不支持截取字符');
	}
}
?>
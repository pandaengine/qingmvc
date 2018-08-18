<?php 
namespace qing\str;
/**
 * 多种“分割字符串”方法
 * 字符串子串
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */
class SubStr{
	/**
	 * 截取字符串，全角半角都占设置长度的一位；支持中文，不会有乱码
	 * echo mb_substr($str, 0, 1, 'utf-8')."\n";
	 * echo mb_substr($str, 0, 2, 'utf-8')."\n";
	 * echo mb_substr($str, 0, 3, 'utf-8')."\n";
	 *
	 * @param string $value
	 * @param number $start
	 * @param number $length 使用的最大字符数。如果省略了此参数或者传入了 NULL，则会提取到字符串的尾部。
	 * 	php 5.4.8 length 传入 NULL，则从 start 提取到字符串的结尾处。 在之前的版本里， NULL 会被当作 0 来处理。
	 * @param string $suffix
	 * @param string $charset 字符编码。如果省略，则使用内部字符编码。
	 * @return string
	 */
	public static function mb_substr($value,$start,$length,$suffix='',$charset='utf-8'){
		$length=(int)$length;
		$realLength=mb_strlen($value,$charset);
		if($realLength<=$length){
			//#不需要截取|没有后缀
			return $value;
		}
		$value=mb_substr($value, $start, $length, $charset);
		//追加后缀
		return $value.$suffix;
	}
	/**
	 * 截取字符串，全角半角都占设置长度的一位；支持中文，不会有乱码
	 * echo iconv_substr($str, 0, 1, 'utf-8')."\n";
	 * echo iconv_substr($str, 0, 2, 'utf-8')."\n";
	 * echo iconv_substr($str, 0, 3, 'utf-8')."\n";
	 *
	 * @param string $value
	 * @param number $start
	 * @param number $length
	 * @param string $suffix
	 * @param string $charset
	 * @return string
	 */
	public static function iconv_substr($value,$start,$length,$suffix='',$charset='utf-8'){
		$length=(int)$length;
		$realLength=iconv_strlen($value,$charset);
		if($realLength<=$length){
			//#不需要截取|没有后缀
			return $value;
		}
		$value=iconv_substr($value,$start,$length,$charset);
		//追加后缀
		return $value.$suffix;
	}
	/**
	 * 截取字符串/子字符串；中文会有乱码
	 * ------------------------
	 * 半角占一位
	 * 全角占两位
	 * utf8:半角占1个字节长度，全角占3个字节长度
	 * ------------------------
	 * $str = "一1二2三3四4五5六6七7八8九9十0";
	 * echo substr($str,0,1)."\n"; // *
	 * echo substr($str,0,2)."\n"; // **
	 * echo substr($str,0,3)."\n"; // 一
	 * echo substr($str,0,4)."\n"; // 一1
	 * ------------------------
	 * @param string $value
	 * @param string $start
	 * 必须：规定在字符串的何处开始。
	 *      # 正数 - 在字符串的指定位置开始
	 * 		# 负数 - 在从字符串结尾的指定位置开始
	 * 		# 0  - 在字符串中的第一个字符处开始
	 * @param string $length
	 * 		可选。规定要返回的字符串长度。默认是直到字符串的结尾。
	 * 		# 正数 - 从 start 参数所在的位置返回
	 * 		# 负数 - 从字符串末端返回
	 * @param string $suffix
	 */
	public static function substr($value,$start,$length,$suffix=''){
		$length=(int)$length;
		if(strlen($value)<=$length){
			//#不需要截取|没有后缀
			return $value;
		}
		$value=substr($value,$start,$length);
		//追加后缀
		return $value.$suffix;
	}
}
?>
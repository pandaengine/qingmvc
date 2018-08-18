<?php 
namespace qing\validator;
/**
 * 字符串长度验证器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class StrLen{
	/**
	 * 验证字符长度,所有字符,包括中文，字母数字
	 * 
	 * 1. UTF8的中文字符是3个长度，所以“中文a字1符”长度是3*4+2=14,
	 * 2. 在mb_strlen计算时，选定内码为UTF8，则会将一个中文字符当作长度1来计算，所以“中文a字1符”长度是6.
	 * 3. 利用这两个函数则可以联合计算出一个中英文混排的串的占位是多少（一个中文字符的占位是2，英文字符是1） echo (strlen($str) + mb_strlen($str,'UTF8')) / 2;
	 * -----
	 * 1.字母和数字占位1；半角占一个长度
	 * 2.中文占位3；全角占3个长度
	 * -----
	 * 
	 * @param string $string
	 * @param number $min
	 * @param number $max
	 * @return boolean
	 */
	public static function validate($string,$min,$max){
		$len=strlen($string);
		if($len>=$min && $len<=$max){
			return true;
		}else{
			return false;
		}
	}
}
?>
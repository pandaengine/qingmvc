<?php 
namespace qing\string\traits;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */

/**
 * -返回字符串的字符数统计
 * -和 strlen() 不同的是，iconv_strlen() 统计了给定的字节序列 str 中出现字符数的统计，基于指定的字符集，其产生的结果不一定和字符字节数相等。
 * -默认已激活此扩展，但是它能够在编译时通过 --without-iconv 选项被禁用。
 * 
 * @param string $value
 * @param string $charset
 * @return number
 */
function iconv_strlen($value,$charset='utf-8'){
	return iconv_strlen($value,$charset);
}
/**
 * 验证字符长度,所有字符,包括中文，字母数字
 * 1. UTF8的中文字符是3个长度，所以“中文a字1符”长度是3*4+2=14,
 * 2. 在mb_strlen计算时，选定内码为UTF8，则会将一个中文字符当作长度1来计算，所以“中文a字1符”长度是6.
 * 3. 利用这两个函数则可以联合计算出一个中英文混排的串的占位是多少（一个中文字符的占位是2，英文字符是1） echo (strlen($str) + mb_strlen($str,'UTF8')) / 2;
 * --------------------------------------
 * 1.字母和数字占位1；半角占一个长度
 * 2.中文占位3；全角占3个长度
 * --------------------------------------
 *
 * @param string $value
 * @return number
 */
function strlen($value){
	return strlen($value);
}
/**
 * -mb_strlen—获取字符串的长度
 * -返回具有 encoding 编码的字符串 str 包含的字符数。 多字节的字符被计为 1。
 * -中文可以为utf8编码
 * 
 * //测试时文件的编码方式要是UTF8
 * $str='中文a字1符';
 * echo strlen($str).'<br>';//14
 * echo mb_strlen($str,'utf8').'<br>';//6
 * echo mb_strlen($str,'gbk').'<br>';//8
 * echo mb_strlen($str,'gb2312').'<br>';//10
 * --------------------------------------------
 * 1.字母和数字占位1
 * 2.中文占位1
 *
 * @param string $value
 * @return number
 */
function mb_strlen($value,$charset='utf-8'){
	return mb_strlen($value,$this->charset);
}

?>
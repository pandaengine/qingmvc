<?php
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
/**
 * 字符个数，中文/字母/数字均只占一个字符
 *
 * @notice 和占用字节数不同无关
 * @see \qing\string\CharNum
 * @param string $string
 * @param string $charset 编码|utf-8|gb2312|gbk|big5
 * @return number
 */
function charnum($string,$charset='utf-8'){
	if(function_exists('mb_strlen')){
		return mb_strlen($string,$charset);
	}elseif(function_exists('iconv_strlen')) {
		return iconv_strlen($string,$charset);
	}else{
		throw new \Exception('不支持获取字符个数');
	}
}
/**
 * 截取字符，中文/字母/数字均只占一个字符
 *
 * @notice 和占用字节数不同无关
 * @see \qing\string\SubChar
 * @param string $value
 * @param number $start
 * @param number $length
 * @param string $suffix
 * @param string $charset
 */
function subchar($value,$start,$length,$suffix='',$charset='utf-8'){
	return \qing\string\SubChar::subChar($value,$start,$length,$suffix,$charset);
}

?>
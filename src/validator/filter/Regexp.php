<?php
namespace qing\validator\filter;
/**
 * 自定义正则表达式过滤器
 * 正则表达式|清除匹配
 *
 * @deprecated 直接使用preg_replace
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Regexp{
	/**
	 * 正则表达式|清除匹配
	 * ---
	 * $value   = "abcdef";
	 * $pattern = '/abc/';		清除abc字符
	 * $pattern = '/[^abc]/';	清除除了abc以外的字符
	 * $pattern = '/^abc/';		清除字符开头的abc字符
	 * ---
	 * @param string $value   过滤的值
	 * @param string $pattern 要搜索的模式/字符串类型。
	 * @return string
	 */
	public function filter($value,$pattern){
		return preg_replace($pattern,'',$value);
	}
}
?>
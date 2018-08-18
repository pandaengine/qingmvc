<?php
namespace qing\validator\filter;
/**
 * 文本过滤器
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Text{
	/**
	 * 过滤空白字符
	 * 空格空行\t\n
	 * \s: 空白字符
	 * \S: 非空白字符
	 * ---
	 * return str_replace(array("\r","\n","\t"),'',$value);
	 *
	 * @name removeSpace
	 * @param string $value
	 * @return string
	 */
	public static function clearBlank($value){
		return preg_replace('/\s/','',$value);
	}
	/**
	 * 移除（清除）冗余的空格
	 * 两个以上空格替换成一个空格
	 * 
	 * - array("\r","\n","\t")等替换成一个空格
	 * - 英文不能清除所有空格
	 *
	 * @param string $value
	 * @return mixed
	 */
	public static function clearMoreBlank($value){
		return preg_replace('/\s+/',' ',$value);
	}
}
?>
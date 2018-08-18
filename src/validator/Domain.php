<?php
namespace qing\validator;
/**
 * domain验证器
 * 
 
$value='s.1-9.v6.demo.qingcms.com';

提示：域名可由英文字母（a-z，不区分大小写）、数字（0-9）、中文汉字以及连字符"-"（即中横线）构成，
不能使用空格及特殊字符（如！、$、&、?等）。
“-” 不能单独注册或连续使用，不能放在开头或结尾。

- 减号-不在开头或结尾

 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Domain{
	/**
	 * 验证域名，包括二级域名
	 * 
	 * demo.qingmvc.com.cn
	 * 
	 * 域名后缀：.com/.com.cn/.cn
	 * http://www.qingcms.com
	 * www.qingcms.com
	 * s.1-9.v6.demo.qingcms.com
	 * ---
	 * - 数字或字母开头结尾|中间可以有减号-
	 * - .com .cn .wang 多个组合不限制长度
	 * - 尾部为顶级域名，一般没有减号-/.com .cn .net
	 * - 用户域名和二级域名可以有减号-/de-mo.qing-mvc
	 * 
	 * TODO 后缀不再是2,3,5|还有4等等 .wang
	 * 
	 * @param $value
	 */
	public static function validate($value){
		//(单字符|多字符，允许减号-，a-b)
		return preg_match('/^(?:[A-Z0-9]|[A-Z0-9][A-Z0-9\-]*[A-Z0-9])+(?:\.[A-Z0-9\-]+)+$/i',$value)>0;
	}
	/**
	 * 一级域名，特指的是用户注册的域名
	 * 二级域名，特指用户在自己域名上配置的子域名
	 * 
	 * 顶级域名：国家顶级域名  国际顶级域名 .com .cn
	 * 
	 * qing-mvc.com.cn
	 * qing-mvc.wang
	 * q.com.cn
	 * 
	 * ?: 不捕获子组
	 * 
	 * @deprecated
	 * @param string $value
	 * @return boolean
	 */
	public static function top($value){
		return preg_match('/^(?:[A-Z0-9]|[A-Z0-9][A-Z0-9\-]*[A-Z0-9])(?:\.[A-Z0-9]+)+$/i',$value)>0;
	}
	/**
	 * 包括scheme
	 * https://qingmvc.com
	 * 
	 * @param string $value
	 * @param array  $schemes 允许的schemes,注意设置为小写
	 * @return boolean
	 */
	public static function withScheme($value,array $schemes=['http','https']){
		
	}
}
?>
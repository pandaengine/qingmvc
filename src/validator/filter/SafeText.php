<?php
namespace qing\validator\filter;
/**
 * 安全文本过滤器
 * 返回安全文本safeText|剥离html/php标签->sql语句编码
 * 转义危险字符，php标签，html标签，sql注入标签
 * 
 * # htmlentities
 * - 单引号转义符号反斜杠没有转义: '\
 * 
 * @see Sql
 * @see Escape
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SafeText{
	/**
	 * 安全字符，供html使用
	 * 避免xss
	 * 避免输出引号<>等影响html展示混乱/变相XSS
	 * 
	 * @see Html
	 * @param string $value
	 * @return string
	 */
	public static function filter($value){
		//#剥离php/html标签
		$value=strip_tags($value);
		//单双引号等转换为实体|\转义符号没有转换!
		//$value=Html::entities($value);
		$value=htmlentities($value,ENT_QUOTES,'UTF-8');
		//转义特殊符号，' " \ NULL
		//$value=Escape::filter($value);
		$value=addslashes($value);
		return $value;
	}
	/**
	 * 安全字符，供sql使用
	 * 避免sql注入
	 * 
	 * @param string $value
	 * @param string $like
	 * @return string
	 */
	public static function sql($value,$like=false){
		$value=self::filter($value);
		return $like?Sql::like($value):$value;
	}
}
?>
<?php
namespace qing\validator\filter;
/**
 * url验证器
 * 必须以https?://开头
 * 
 * @deprecated 无法正确处理xss威胁，host,path,query所有段的xss威胁都没有过滤，各种危险符号均没有过滤
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UrlFilter{
	/**
	 * FILTER_SANITIZE_URL 过滤器删除字符串中所有非法的 URL 字符。
	 * 该过滤器允许所有的字母、数字以及 ```$-_.+!*'(),{}|\^~[]`"><#%;/?:@&=```
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public static function filter($value){
		return filter_var($value,\FILTER_SANITIZE_URL);
	}
}
?>
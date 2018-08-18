<?php
namespace qing\validator;
/**
 * url验证器
 * 必须以https?://开头
 * 
 * @deprecated 无法正确处理xss威胁，只简单验证域名，path,query等段xss威胁不验证
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UrlValidator{
	/**
	 * # FILTER_VALIDATE_URL
	 * 
	 * - 参数
	 * FILTER_FLAG_SCHEME_REQUIRED - 要求 URL 是 RFC 兼容 URL（比如 http://example）//必须包含scheme http:// https://
	 * FILTER_FLAG_HOST_REQUIRED - 要求 URL 包含主机名（比如 http://www.example.com）//必须包含主机名
	 * FILTER_FLAG_PATH_REQUIRED - 要求 URL 在域名后存在路径（比如 www.example.com/example1/test2/）//必须包含path
	 * FILTER_FLAG_QUERY_REQUIRED - 要求 URL 存在查询字符串（比如 "example.php?name=Peter&age=37"）//必须包含query
	 * 
	 * - query里有中文: 总是失败
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public static function validate($value){
		return filter_var($value,\FILTER_VALIDATE_URL)!==false;
	}
	/**
	 * 高级验证方法
	 * 
	 * true:必须  false:不是必须，可有可无
	 * 
	 * @param string $value
	 * @param string $scheme scheme true:必须 false:可有可无
	 * @param string $host host必须
	 * @param string $path path必须
	 * @param string $query query必须
	 * @return boolean
	 */
	public static function adv($value,$scheme=true,$host=true,$path=true,$query=true){
		$options=0;
		$scheme && $options|=FILTER_FLAG_SCHEME_REQUIRED;
		$host && $options|=FILTER_FLAG_HOST_REQUIRED;
		$path && $options|=FILTER_FLAG_PATH_REQUIRED;
		$query && $options|=FILTER_FLAG_QUERY_REQUIRED;
		//
		return filter_var($value,\FILTER_VALIDATE_URL,$options)!==false;
	}
}
?>
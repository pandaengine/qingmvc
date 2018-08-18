<?php 
namespace qing\utils;
/**
 * URL相关的一些帮助方法
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0 all rights reserved.
 */
class Url{
	/**
	 * 移除多余的斜杠
	 * 两个以上的斜杠，替换成一个
	 * 
	 * @param  $url	指定url
	 */
	public static function rmSlashes($url){
		return preg_replace('/\/{2,}/','/',$url);
	}
	/**
	 * 更新url参数;
	 * 存在参数则更新，否则添加;
	 *
	 * @param  $params  要修改的参数
	 * @param  $url		指定url
	 */
	public static function updateParams(array $params){
		parse_str($_SERVER['QUERY_STRING'],$arr);
		$arr=array_merge($arr,$params);
		$url=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].@$_SERVER['PATH_INFO'].'?'.http_build_query($arr);
		return $url;
	}
	/**
	 * 检测url是否所在某个host下面
	 * 
	 * ?:|取消子组
	 * 
	 * @param string $url  指定要判断的url
	 * @param string $host 要检测的host主机
	 * @return mixed
	 */
	public static function matchHost($url,$host=''){
		if(!$host){
			$host=$_SERVER['HTTP_HOST'];
		}
		$host	=preg_quote($host);
		$pattern='/^[a-z0-9]+(?:\:\/\/)?'.$host.'/i';
		return preg_match($pattern,$url)>0;
	}
}
?>
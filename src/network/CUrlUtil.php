<?php
namespace qing\network;
/**
 * cUrl请求工具类
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CUrlUtil{
	/**
	 * 手动分割成报头和正文
	 * header获取信息或Cookie
	 * ---
	 * 需要设置withHeader=true
	 *
	 * @param string $raw
	 * @param string $header_size
	 */
	public static function response_header_body($raw,$header_size){
		$head=substr($raw,0,$header_size);
		$body=substr($raw,$header_size);
		return [$head,$body];
	}
	/**
	 * 从报头中获取所有cookie
	 * Set-Cookie: PHPSESSID=d375ohl0l6qh7gg2vle2k6l672; path=/
	 * Cookie names cannot contain any of the following '=,; \t\r\n\013\014'
	 *
	 * @param string $header 报头或所有响应内容，注意：必须包含报头
	 * @param string $decode
	 */
	public static function response_cookies($header,$decode=true){
		//$res=preg_match_all('/Set\-Cookie:\s+([a-z0-9]+)\=([^\r\n;]*);?\s+?([^\r\n]*)/i', $header, $matches);
		$res=preg_match_all('/Set\-Cookie:\s+([^=,; \t\r\n]+)\=([^\r\n;]*)/i', $header, $matches);
		if($res==0){
			return [];
		}
		$cookies=[];
		foreach($matches[1] as $k=>$name){
			$cookies[$name]=$matches[2][$k];
			if($decode){
				$cookies[$name]=urldecode($cookies[$name]);
			}
		}
		return $cookies;
	}
	/**
	 * 从报头中获取cookie
	 *
	 * @param string $header
	 * @param string $name
	 * @param string $decode
	 */
	public static function response_cookie($header,$name,$decode=true){
		$name=preg_quote($name,'/');
		$res=preg_match('/Set\-Cookie:\s+'.$name.'\=([^\r\n;]*)/i', $header, $matches);
		if($res){
			if($decode){
				return urldecode($matches[1]);
			}else{
				return $matches[1];
			}
		}else{
			return '';
		}
	}		
}
?>
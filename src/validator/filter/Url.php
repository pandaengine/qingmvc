<?php 
namespace qing\validator\filter;
use qing\validator\Url as UrlValidator;
/**
 * url过滤危险字符
 * 过滤之后，url要可以正常使用，只是过滤危险字符
 * 
 * # query等号=&不能被编码！|= %3A |只有等号后的值才能使用urlencode
 * 

# parse_url

scheme - 如 http
host
port
user
pass
path
query - 在问号 ? 之后
fragment - 在散列符号 # 之后

 * @name UrlEncoder
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Url{
	/**
	 * 约定：需要有scheme
	 * 如果url已经编码，需要先手动解码urldecode($url);
	 * 
	 * @param string $url
	 * @return string
	 */
	public static function filter($url){
		//#解析url
		$parts=(array)parse_url($url);
		//#host必须通过验证
		if(!isset($parts['host']) || !UrlValidator::host($parts['host'])){
			//url非法，返回空
			return '';
		}
		$scheme=$host=$port=$path=$query=$frag='';
		$host=$parts['host'];
		if(isset($parts['scheme'])){
			//过滤scheme，不限定http,ftp,file
			$scheme=SafeChar::abc123($parts['scheme']);
			$scheme=$scheme.'://';
		}
		if(isset($parts['port'])){
			$port=':'.(int)$parts['port'];
		}
		if(isset($parts['path'])){
			$path=self::path($parts['path']);
		}
		if(isset($parts['query'])){
			$query='?'.self::query($parts['query']);
		}
		if(isset($parts['fragment'])){
			$frag='#'.self::fragment($parts['fragment']);
		}
		return "{$scheme}{$host}{$port}{$path}{$query}{$frag}";
	}
	/**
	 * 过滤port
	 *
	 * @param string $port
	 * @return string
	 */
	public static function port($port){
		return (int)$port;
	}
 	/**
 	 * 过滤path
 	 * 
	 * @param string $path
	 * @return string
	 */
	public static function path($path){
// 		return htmlentities($path);
// 		return urlencode($path);
		return SafeText::filter($path);
	}
	/**
	 * 过滤query
	 * 不能直接urlencode($query)，需要分解&一个个参数的encode
	 * 
	 * # parse_str:将字符串解析成多个变量
	 * $str = "first=value&arr[]=foo+bar&arr[]=baz";
	 * parse_str($str, $output);
	 * 
	 * # http_build_query — 生成 URL-encode 之后的请求字符串
	 * - 键值和值都会编码
	 * 
	 * @return string
	 */
	public static function query($query){
		parse_str($query,$arr);
		/*
		$new=[];
		foreach($arr as $key=>$value){
			//安全过滤键值和数组|键值也必须转义
			$key  =urlencode($key);
			$value=urlencode($value);
			$new[$key]=$value;
		}
		*/
		//该函数会自动编码键值和值
		return http_build_query($arr);
	}
	/**
	 * 过滤锚点
	 * 
	 * ?a=1#id
	 * 
	 * @return string
	 */
	public static function fragment($frag){
		//return htmlentities($frag);
		//return urlencode($frag);
		return SafeText::filter($frag);
	}
}
?>
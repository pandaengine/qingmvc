<?php 
namespace qing\url;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Utils{
	/**
	 * 更新当前url的一些参数
	 *
	 * @param string $url
	 * @param string $push
	 * @return string
	 */
	public static function push_query($url,$push){
		if(!$push){
			return $url;
		}else{
			if(strpos($url,'?')===false){
				$and='?';
			}else{
				$and='&';
			}
			return $url.$and.$push;
		}
	}
	/**
	 * 生成get方式的url
	 * $url=urldecode($url);
	 * 
	 * @param array $params
	 * @return string
	 */
	public static function createGetParams(array $params){
		//空格/大括号等会被编码
		$url=http_build_query($params);
		return $url;
	}
	/**
	 * 生成path方式的url
	 * 生成链接，相当于v1的 U();
	 *
	 * @param array $params
	 * @return string
	 */
	public static function createPathParams(array $params){
		$url=implode('/',$params);
		$url=ltrim($url,'/');
		return $url;
	}
	/**
	 * $_SERVER['PATH_INFO'] XSS 风险
	 * 
	 * @deprecated XSS风险
	 * @name __PATH__
	 * @return string
	 */
	public static function getPathUrl(){
		$pathInfo=@$_SERVER['PATH_INFO'];
		if($pathInfo){
			return __APP__.'/'.$pathInfo;
		}else{
			return __APP__;
		}
	}
	/**
	 * 当前完整访问链接
	 * 
	 * @name __URL__
	 * @return string
	 */
	public static function getFullUrl(){
		$host=$_SERVER['REQUEST_METHOD'].'://'.$_SERVER['HTTP_HOST'];
		//REQUEST_URI已经过安全编码
		$requestUri=$_SERVER['REQUEST_URI'];
		return $host.$requestUri;
	}
}	
?>
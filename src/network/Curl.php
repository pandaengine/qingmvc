<?php
namespace qing\network;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Curl{
	/**
	 * 使用curl发送post请求,携带cookie
	 *
	 * @param string $url	请求url
	 * @param array  $post  post数据
	 * @param string/array  $cookies cookie a=aaa;b=bbb
	 * @return string
	 */
	public static function postAndCookie($url,array $post=[],$cookies=''){
		if(is_array($cookies)){
			$cookies=http_build_query($cookies);
		}else{
			$cookies=(string)$cookies;
		}
		return self::post($url,$post,[CURLOPT_COOKIE=>$cookies]);
	}
	/**
	 * 使用curl提交数据
	 * 使用curl发送post请求
	 *
	 * @param string $url	请求url
	 * @param array  $post  post数据
	 * @param array $options  附加选项
	 * @return string
	 */
	public static function post($url,array $post=[],array $options=[]){
		$defaults = array(
				CURLOPT_POST => 1,
				CURLOPT_HEADER => 0,
				CURLOPT_URL => $url,
				CURLOPT_FRESH_CONNECT => 1,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_FORBID_REUSE => 1,
				CURLOPT_TIMEOUT => 4,
				//CURLOPT_POSTFIELDS => http_build_query($post)
				CURLOPT_POSTFIELDS => $post
		);
		$ch = curl_init();
		curl_setopt_array($ch, ($options + $defaults));
		if(!$result = curl_exec($ch)){
			trigger_error(curl_error($ch));
			return false;
		}
		//http_code
		//$info = curl_getinfo($ch);
		curl_close($ch);
// 		if($info['http_code']!=200){
// 			//#状态码不是200/404/301
// 			return $info['http_code'].': '.$info['url'];
// 		}
		return $result;
	}
	/**
	 * Send a GET requst using cURL
	 * 
	 * @param string $url to request
	 * @param array $get values to send
	 * @param array $options for cURL
	 * @return string
	 */
	public static function get($url,array $get=[],array $options=[]){
		if(strpos($url,'?')===false){
			//没有问号
			$connector='?';
		}else{
			//有问号
			$connector='&';
		}
		$url=$url.$connector. http_build_query($get);
		//
		$defaults = array(
				CURLOPT_URL =>$url,
				CURLOPT_HEADER => 0,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_TIMEOUT => 4
		);
		$ch = curl_init();
		curl_setopt_array($ch, ($options + $defaults));
		if(!$result=curl_exec($ch)){
			trigger_error(curl_error($ch));
			return false;
		}
		curl_close($ch);
		return $result;
	}
}
?>
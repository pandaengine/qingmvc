<?php
namespace qing\utils;
/**
 * 客户端/服务器ip
 * 
 * @see $_SERVER server.md
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class IP{
	/**
	 * 客户端IP地址
	 *
	 * @param bool $tolong 返回长整型还是字符串
	 */
	static public function client($tolong=false){
		static $_ip=null;
		if(is_null($_ip)){
			if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
				//1.用户的代理IP
				$arr=explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				$pos=array_search('unknown',$arr);
				if(false!==$pos){
					unset($arr[$pos]);
				}
				$ip=trim($arr[0]);
			}elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
				//2.代理服务器发送的HTTP头，可伪造
				$ip=$_SERVER['HTTP_CLIENT_IP'];
			}elseif(isset($_SERVER['REMOTE_ADDR'])){
				//3.客户端跟你的服务器“握手”时候的IP，较准确
				$ip=$_SERVER['REMOTE_ADDR'];
			}
			//4.IP地址合法验证
			$long=sprintf("%u",ip2long($ip));//无符号十进制
			$_ip =$long?[$ip, $long]:['0.0.0.0',0];
		}
		if($tolong){
			//1.返回长整型
			return $_ip[1];
		}else{
			//2.返回四段字符串
			return $_ip[0];
		}
	}
	/**
	 * 服务器IP
	 * web服务器所在ip
	 */
	static public function server(){
		return $_SERVER['SERVER_ADDR'];
	}
}
?>
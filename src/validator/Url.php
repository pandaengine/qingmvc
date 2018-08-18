<?php
namespace qing\validator;
/**
 * url验证器
 * 必须以https?://开头
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Url{
	/**
	 * 
	 * @param string $value 必须以http://开头，否则parse_url无法解析
	 * @param array  $schemes 允许的schemes,注意设置为小写
	 * @return boolean
	 */
	public static function validate($value,array $schemes=['http','https']){
		$arr=parse_url($value);
		if(!isset($arr['scheme']) || !isset($arr['host'])){
			return false;
		}
		$scheme=(string)$arr['scheme'];
		$domain=(string)$arr['host'];
		//#scheme
		if($schemes && !self::scheme($scheme,$schemes)){
			return false;
		}
		//#domain
		if($domain==''){
			return false;
		}
		return Domain::validate($domain);
	}
	/**
	 * 验证scheme
	 * http,https,ftp,file,email,ssh
	 * 
	 * @param string $value
	 * @param array  $schemes 允许的schemes,注意设置为小写
	 * @return boolean
	 */
	public static function scheme($value,array $schemes=['http','https']){
		$value=strtolower($value);
		return in_array($value,$schemes);
	}
	/**
	 * 验证host
	 *
	 * @param string $value
	 * @return boolean
	 */
	public static function host($value){
		return Domain::validate($value);
	}
}
?>
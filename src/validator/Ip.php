<?php
namespace qing\validator;
/**
 * Ip验证器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Ip{
	/**
	 * ipv4或ipv6
	 * return (ip2long($value)===false)?false:true;
	 *
	 * @param string $value
	 * @return boolean
	 */
	static public function validate($value){
		return filter_var($value,\FILTER_VALIDATE_IP)!==false;
	}
	/**
	 * 仅ipv4
	 *
	 * @param string $value
	 * @return boolean
	 */
	static public function ipv4($value){
		return filter_var($value,\FILTER_VALIDATE_IP,\FILTER_FLAG_IPV4)!==false;
	}
	/**
	 * 仅ipv6
	 * 
	 * @param string $value
	 * @return boolean
	 */
	static public function ipv6($value){
		return filter_var($value,\FILTER_VALIDATE_IP,\FILTER_FLAG_IPV6)!==false;
	}
}
?>
<?php
namespace qing\validator;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Id{
	/**
	 *
	 * @param string $value
	 * @param number $len
	 * @return boolean
	 */
	static public function validate($value,$len=32){
		return preg_match('/^[a-z0-9]{'.$len.'}$/i',$value)>0;
	}
	/**
	 *
	 * @param string $value
	 * @param number $len
	 * @return boolean
	 */
	static public function guid($value,$len=32){
		return self::validate($value,$len);
	}
	/**
	 *
	 * @param string $value
	 * @param number $len 32/16
	 * @return boolean
	 */
	static public function md5($value,$len=32){
		return self::validate($value,$len);
	}
}
?>
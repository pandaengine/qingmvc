<?php
namespace qing\exceptions;
/**
 * 不能调用异常
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UncallableException extends Exception{
	/**
	 * @param string  $callString  调用字符串
	 * @param string  $message  错误的信息
	 * @param integer $code     错误码
	 */
	public function __construct($callString,$message='',$code=0){
		if($message===''){
			//默认错误
			$message='不能调用:'.$callString;
		}
		parent::__construct($message,$code);
	}
}
?>
<?php
namespace qing\exceptions;
/**
 * 找不到函数
 * 
 * class not found
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NotfoundFunctionException extends Exception{
	/**
	 * @param string  $class    函数名称
	 * @param string  $message  错误的信息
	 * @param integer $code     错误码
	 */
	public function __construct($function,$message='',$code=0){
		if($message===''){
			$message='找不到函数:'.$function;
		}
		parent::__construct($message,$code);
	}
}
?>
<?php
namespace qing\exceptions;
/**
 * 找不到实例
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NotfoundComException extends Exception{
	/**
	 * @param string  $name
	 * @param string  $message  错误的信息
	 * @param integer $code     错误码
	 */
	public function __construct($name,$message='',$code=0){
		if($message===''){
			$message='找不到组件:'.$name;
		}
		parent::__construct($message,$code);
	}
}
?>
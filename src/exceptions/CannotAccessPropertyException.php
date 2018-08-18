<?php
namespace qing\exceptions;
/**
 * 属性不能访问
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CannotAccessPropertyException extends Exception{
	/**
	 * 
	 * @var string
	 */
	public $property='';
	/**
	 * @param string  $value    类名/方法名/属性名|class->prop
	 * @param string  $message  错误的信息
	 * @param integer $code     错误码
	 */
	public function __construct($class,$property,$message='',$code=0){
		if($message===''){
			$message='不能访问属性:'.$class.'->'.$property;
		}
		parent::__construct($message,$code);
	}
}
?>
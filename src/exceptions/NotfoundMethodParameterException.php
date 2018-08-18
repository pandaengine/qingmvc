<?php
namespace qing\exceptions;
/**
 * 找不到类成员方法参数
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NotfoundMethodParameterException extends Exception{
	/**
	 * @var string
	 */
	public $title='找不到方法参数：';
	/**
	 * @param string  $class     类名
	 * @param string  $method    成员方法
	 * @param string  $parameter 参数名称
	 */
	public function __construct($class,$method,$parameter){
		parent::__construct("{$class}::{$method}({$parameter})");
	}
}
?>
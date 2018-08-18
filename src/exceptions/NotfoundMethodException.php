<?php
namespace qing\exceptions;
/**
 * 找不到方法
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NotfoundMethodException extends Exception{
	/**
	 * @var string
	 */
	public $title='找不到类成员方法 : ';
	/**
	 * @param string $class
	 * @param string $method
	 */
	public function __construct($class,$method){
		parent::__construct($class.'::'.$method.'()');
	}
}
?>
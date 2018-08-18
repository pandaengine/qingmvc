<?php
namespace qing\exceptions;
/**
 * 类不匹配|或不是某类某接口的实现
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NotmatchClassException extends Exception{
	/**
	 * @param string  $class    	类名
	 * @param string  $parentClass  父类名称|或者接口名称
	 */
	public function __construct($class,$parentClass){
		parent::__construct($class.' not instanceof '.$parentClass);
	}
	/**
	 * 消息头
	 *
	 * @return string
	 */
	public function getTitle(){
		return '类不匹配: ';
	}
}
?>
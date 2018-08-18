<?php
namespace qing\adapter;
use qing\exceptions\Exception;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UndefinedActionParamException extends Exception{
	/**
	 * @var string
	 */
	public $title='未定义 : ';
}
?>
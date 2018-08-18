<?php
namespace qing\db\exceptions;
use qing\exceptions\Exception;
/**
 * - sql执行错误
 * - 查询或执行错误
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ModelException extends Exception{
	/**
	 * @var string
	 */
	public $title='model : ';
}
?>
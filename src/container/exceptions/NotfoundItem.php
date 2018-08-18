<?php
namespace qing\container\exceptions;
use qing\exceptions\Exception;
/**
 * 找不到实例
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NotfoundItem extends Exception{
	/**
	 * @var string
	 */
	public $title='找不到实例 : ';
}
?>
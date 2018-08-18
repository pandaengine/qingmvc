<?php
namespace qing\exceptions;
/**
 * - 模型错误
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ModelException extends Exception{
	/**
	 * @param string  $message  错误的信息
	 * @param integer $code     错误码
	 */
	public function __construct($message='',$code=0){
		parent::__construct($message,$code);
	}
}
?>
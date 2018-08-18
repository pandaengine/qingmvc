<?php
namespace qing\exceptions\http;
use Exception;
/**
 * 找不到控制器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NotFoundControllerException extends NotFoundHttpException{
	/**
	 * 消息头
	 *
	 * @return string
	 */
	public function getTitle(){
		return '找不到控制器: ';
	}
}
?>
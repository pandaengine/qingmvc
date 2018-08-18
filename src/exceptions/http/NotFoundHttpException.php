<?php
namespace qing\exceptions\http;
/**
 * 404 not found
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NotFoundHttpException extends HttpException{
	/**
	 * http请求状态码   e.g.  403, 404, 500, etc.
	 *
	 * @var integer
	 */
	public $httpCode=404;
	/**
	 * 消息头
	 *
	 * @return string
	 */
	public function getTitle(){
		return '找不到请求: ';
	}
}
?>
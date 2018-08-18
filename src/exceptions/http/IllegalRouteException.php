<?php
namespace qing\exceptions\http;
/**
 * 非法路由，包含非法字符
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class IllegalRouteException extends NotFoundHttpException{
	/**
	 * 模块未初始化，无法使用模块getMessage
	 *
	 * @var string
	 */
	public $handler='alert';
	/**
	 * 消息头
	 *
	 * @return string
	 */
	public function getTitle(){
		return '非法路由，只能包含字母数字下划线 ： ';
	}
}
?>
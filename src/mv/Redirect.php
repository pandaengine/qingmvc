<?php
namespace qing\mv;
use qing\response\Redirect;
use qing\http\Location;
/**
 * 
 * @deprecated use MV::redirect
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Redirect{
	/**
	 * 返回重定向响应
	 * 重定向到一个指定的链接
	 *
	 * @bug ajax返回html,json解析错误
	 * @for page not ajax
	 * @param string  $redirect   重定向位置
	 * @param integer $statusCode http状态码|默认为302临时重定向
	 */
	static public function create($redirect,$statusCode=302){
		return new Redirect($redirect,$statusCode);
	}
	/**
	 * 
	 * @param string  $redirect   重定向位置
	 * @param integer $statusCode http状态码|默认为302临时重定向
	 */
	static public function header($redirect,$statusCode=302){
		Location::header($redirect,$statusCode);
	}
	/**
	 * 重定向跳转|立即跳转
	 *
	 * @param string  $redirect   重定向位置
	 * @param integer $statusCode http状态码|默认为302临时重定向
	 */
	static public function jump($redirect,$statusCode=302){
		(new Redirect($redirect,$statusCode))->send();
		return MV_NULL;
	}
	/**
	 * 刷新当前页面，使用js完成
	 *
	 * @bug ajax返回html,json解析错误
	 * @see \qing\response\Refresh
	 */
	static public function refresh($exit=false){
		//内容
		$content=
		'<!DOCTYPE html>
		<html>
		<head>
		<meta charset="UTF-8" />
		<title>refresh page</title>
		</head>
		<body>
		<script type="text/javascript">location.reload();</script>
		</body>
		</html>';
		echo $content;
		if($exit) exit();
		return MV_NULL;
	}
}
?>
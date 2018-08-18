<?php 
namespace qing\response;
use qing\http\Response;
/**
 * 刷新当前页面，使用js完成
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Refresh extends Response{
	/**
	 * 发送内容主体
	 */
	public function sendContent(){
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
	}
}
?>
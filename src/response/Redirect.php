<?php 
namespace qing\response;
use qing\http\Response;
/**
 * 重定向响应
 * 重定向到一个指定的链接
 * 
 * 301：
 * - HTTP/1.1 301 Moved Permanently
 * - 目标永久性转移|永久重定向；资源原本确实存在，但已经被永久改变了位置
 * 302：
 * - HTTP/1.1 302 Found|目标暂时性转移|
 * 
 * header("HTTP/1.1 301 Moved Permanently");
 * header('Location:http://demo.qingcms.com');
 * ---
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Redirect extends Response{
	/**
	 * 构造函数
	 *
	 * @param string $redirect 重定向url
	 * @param int    $status   响应状态码/301/302
	 * @return void
	 */
	public function __construct($redirect,$status=302){
		parent::__construct($status);
		if($redirect>''){
			//#重定向到指定地址
			//Location
			$this->setLocation($redirect);
			$this->setContent('正在重定向...');
		}else{
			//#返回|只能使用js来完成
			$this->back();
		}
	}
	/**
	 * 返回
	 * 只能使用js来完成: history.back();
	 * 浏览器可以返回，服务器无法获取上一个页面url
	 * 
	 * @bug 
	 * - ajax请求时，登录失效跳转，返回html，json解析错误！
	 * - 使用header_location,则可正常跳转
	 * - 只能用于正常的页面请求，不适用于ajax
	 * 
	 * @return void
	 */
	protected function back(){
		//内容
		$content=
		'<!DOCTYPE html>
		<html>
		<head>
		<meta charset="UTF-8" />
		<title>go back</title>
		</head>
		<body>
		<script type="text/javascript">history.back();</script>
		</body>
		</html>';
		$this->setContent($content);
	}
}
?>
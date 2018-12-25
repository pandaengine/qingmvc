<?php
namespace qing\mv;
use qing\response\Redirect;
/**
 * model and view
 * 
 * MV::success('haha',[MV::redirect=>'http://'])
 * MV::error('haha',[MV::autojump=>false,MV::redirect=>'baidu.com'])
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MV extends Message{
	/**
	 * 基于视图的消息提示
	 * 模块中自定义处理
	 * 
	 * @param array $params
	 * @return \qing\mv\ModelAndView
	 */
	public static function show(array $params){
		//#使用当前模块的消息提示视图
		$res=mod(AUTO_MODULE)->getMessage($params);
		if($res===false){
			//使用默认提示视图
			return Alert::show($params);
		}else{
			return $res;
		}
	}
	/**
	 * 创建一个ModelAndView实例
	 *
	 * @param string $viewName  模版文件
	 * @param array  $vars      模版变量
	 * @return \qing\mv\ModelAndView
	 */
	public static function create($viewName='',array $vars=[]){
		return new ModelAndView($viewName,$vars);
	}
	/**
	 * 返回重定向响应
	 * 重定向到一个指定的链接
	 *
	 * @see header_location($location)
	 * @see header_location_php($location);
	 * @bug ajax返回html,json解析错误
	 * @for page not ajax
	 * @param string  $redirect   重定向位置
	 * @param integer $statusCode http状态码|默认为302临时重定向
	 */
	public static function redirect($redirect,$statusCode=302){
		return new Redirect($redirect,$statusCode);
	}
	/**
	 * 重定向跳转|立即跳转
	 *
	 * @param string  $redirect   重定向位置
	 * @param integer $statusCode http状态码|默认为302临时重定向
	 */
	public static function jump($redirect,$statusCode=302){
		(new Redirect($redirect,$statusCode))->send();
		return MV_NULL;
	}
	/**
	 * 返回
	 *
	 * @param integer $statusCode http状态码|默认为302临时重定向
	 */
	public static function back($statusCode=302){
		return new Redirect('',$statusCode);
	}
	/**
	 * 刷新当前页面，使用js完成location.reload();
	 *
	 * @bug ajax返回html,json解析错误
	 * @name refresh
	 * @see \qing\response\Refresh
	 */
	public static function refresh($exit=false){
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
<?php
namespace qing\router;
use qing\interceptor\Interceptor;
/**
 * - 简单的路由处理器
 * - 而不需要使用qrouter扩展
 * 
 * 例如
 * p/12345
 * read/1231
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SimpleRouteInterceptor extends Interceptor{
	/**
	 * @see \qing\mvc\Parser\ParserInterceptorInterface::preHandle()
	 */
	public function preHandle(){
		//#pathinfo段
		//$pathinfo=\Qing::$request->getPathInfo();
		$pathinfo=(string)@$_SERVER['PATH_INFO'];
		$pathinfo=trim($pathinfo,'/');
		if($pathinfo>''){
			//#/note/123
			if(preg_match('/^note\/([0-9]+)$/i',$pathinfo,$matches)){
				$id=(int)$matches[1];
				$_GET['id']=$id;
				//#接管路由
				$routebag=new RouteBag('','Note','index');
				$router=coms()->getRouter();
				$router->takeover($routebag);
			}
		}
		return true;
	}
}
?>
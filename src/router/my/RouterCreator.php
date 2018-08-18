<?php
namespace qing\router\my;
use qing\com\ComCreator;
use qing\router\parser\GetParser;
use qing\router\parser\PathInfoParser;
use qing\router\Router;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class RouterCreator extends ComCreator{
	/**
	 * @return \qing\router\Router
	 */
	public function create(){
		$router=new Router();
		$router->keyModule='m';
		
		//#simple|path之前
		$simpleParser=new SimpleParser($router);
		$router->pushParser($simpleParser);
		
		//#pathinfo|
		$pathParser=new PathInfoParser($router);
		$router->pushParser($pathParser);
		
		//#get|pathinfo为空时才get
		$getParser=new GetParser($router);
		$router->pushParser($getParser);
		
		//#默认路由|末端处理器
		//$defParser=new \qing\router\parser\DefParser($router);
		//$router->pushParser($defParser);
		
		return $router;
	}
}
?>
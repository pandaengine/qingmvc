<?php
namespace qing\routers;
use qing\router\parser\PathInfoParser;
use qing\com\ComCreator;
use qing\router\Router;
/**
 * 
 * @see nikic/fast-route
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FastRouteCreator extends ComCreator{
	/**
	 * @see \qing\com\ComCreator::create()
	 */
	public function create(){
		$router=new Router();
		
		//#FastRoute
		$fastRouteParser=new FastRouteParser();
		$router->pushParser($fastRouteParser);
		
		//#pathinfo
		$pathParser=new PathInfoParser($router);
		$router->pushParser($pathParser);
		
		return $router;
	}
}
?>
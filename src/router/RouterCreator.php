<?php
namespace qing\router;
//use qing\router\parser\GetParser;
use qing\router\parser\PathInfoParser;
use qing\com\ComCreator;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class RouterCreator extends ComCreator{
	/**
	 * @see \qing\com\ComCreator::create()
	 */
	public function create(){
		$router=new Router();
		
		//#路由别名
		//$aliasParser=new RouteAlias();
		//$aliasParser=com('route_alias');
		//$router->pushParser($aliasParser);
		
		//#pathinfo|
		$pathParser=new PathInfoParser($router);
		$router->pushParser($pathParser);
		
		//#get|pathinfo为空时才get
		//$getParser=new GetParser($router);
		//$router->pushParser($getParser);
		
		return $router;
	}
}
?>
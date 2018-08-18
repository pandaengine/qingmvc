<?php 
namespace qing\url;
use qing\com\ComCreator;
use qing\url\creators\Path;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UrlManagerCreator extends ComCreator{
	/**
	 * @see \qing\com\ComCreator::create()
	 */
	public function create(){
		$manager=new UrlManager();
		
		//#设置url生成器
		//$manager->pushCreator(new Get());
		
		//路由别名，同时处理路由解析/\qing\router\RouteAlias
		//$manager->pushCreator(com('route_alias'));
		
		//url别名，比路由别名有更高级的用法
		//$manager->pushCreator(com('url_alias'));
		
		$manager->pushCreator(new Path());
		
		return $manager;
	}
}
?>
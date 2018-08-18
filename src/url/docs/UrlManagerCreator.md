
`
$manager=new UrlManager();

//#设置url生成器
//$manager->pushCreator(new Get());

//路由别名，同时处理路由解析/\qing\router\RouteAlias
//$manager->pushCreator(com('route_alias'));

//url别名，比路由别名有更高级的用法
//$manager->pushCreator(com('url_alias'));

$manager->pushCreator(new Path());

return $manager;
		
`
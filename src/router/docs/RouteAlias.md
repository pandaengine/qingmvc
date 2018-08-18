
`
'route_alias'=>
[
	'class'=>'\qing\router\RouteAlias',
	'maps' =>
	[
		'login2'=>'login2@index',
		'user'=>'u@Index@index',
		'reg'=>'reg@index',
	]
],

//#路由别名
//$aliasParser=new RouteAlias();
$aliasParser=com('route_alias');
$router->pushParser($aliasParser);

`
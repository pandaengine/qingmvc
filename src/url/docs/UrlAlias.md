
`
'url_alias'=>
[
	'class'=>'\qing\url\creators\UrlAlias',
	'maps' =>
	[
		'login2@index'=>'login2',
		'u@index@index'=>'user',
		'reg@index'=>'reg',
		'home@index'=>function(&$params){
			$url=vsprintf('home/%s/%s',[$params['id'],$params['username']]);
			unset($params['id']);
			unset($params['username']);
			return $url;
		}
	]
],

//#路由别名
//$aliasParser=new RouteAlias();
$aliasParser=com('route_alias');
$router->pushParser($aliasParser);

dump(U('add'));
dump(U('home','',['id'=>21,'username'=>'xiaowang']));
		
/**
 * - 使用引用传递参数
 * - 删除删除将不会在组建附加get参数
 *
 * @param array  $params
 * @return mixed
 */
/*
public function u_email_index(&$params=[]){
	$url=vsprintf(__APP__.'/email/%s/%s',[$params['id'],$params['username']]);
	unset($params['id']);
	unset($params['username']);
	return $url;
}
*/
	
`
<?php
namespace qing\routers;
use qing\com\Component;
use qing\router\ParserInterface;
use qing\router\RouteBag;
use qing\router\Utils;
//use qing\exceptions\http\NotFoundHttpException;
use FastRoute;
/**
 * FastRoute路由解析器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FastRouteParser extends Component implements ParserInterface{
	/**
	 * 如果开启debug，则是实时解析不缓存
	 * 如果没有开启debug,缓存，要更新缓存必须手动删除缓存
	 * 
	 * @var string
	 */
	public $debug=false;
	/**
	 * 路由文件名称
	 * 
	 * @var string
	 */
	public $fileName='routes.fast';
	/**
	 * 
	 * @see \qing\router\ParserInterface::match()
	 */
	public function parse(){
		$uri=(string)@$_SERVER['PATH_INFO'];
		if($uri){$uri=trim($uri,'/');}
		if(!$uri){
			//使用默认路由
			return ParserInterface::INDEX;
		}
		$cacheFile=APP_CONFIG.DS.$this->fileName.'.cache.php';
		//创建调度器
		$dispatcher=FastRoute\cachedDispatcher(function(FastRoute\RouteCollector $r){
			//加载路由,静态路由不能有前缀反斜杠/
			$routeFile=APP_CONFIG.DS.$this->fileName.'.php';
			if(is_file($routeFile)){
				require $routeFile;
			}
		},
		[
			/* required */
			'cacheFile' =>$cacheFile,
			/* optional, enabled by default */
			'cacheDisabled' => $this->debug,
		]);
		//
		$httpMethod=$_SERVER['REQUEST_METHOD'];
		//路由解析
		$routeInfo=$dispatcher->dispatch($httpMethod,$uri);
		//
		if($routeInfo[0]==FastRoute\Dispatcher::FOUND){
			//#解析成功
			$route=$routeInfo[1];
			$vars =$routeInfo[2];
			//#路由变量，合并到$_GET
			if($vars){
				$_GET=array_merge($_GET,$vars);
			}
			//#路由包解析，数组或字符串
			$route=Utils::format($route);
			return new RouteBag($route[0],$route[1],$route[2]);
		}else{
			//#解析失败
			/*
			if(APP_DEBUG){
				//调试模式提示
				switch($routeInfo[0]){
					//=0
					case FastRoute\Dispatcher::NOT_FOUND:
						//解析失败/找不到路由/404 Not Found
						throw new NotFoundHttpException('找不到路由');
						break;
					//=2
					case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
						//$allowedMethods = $routeInfo[1];
						//解析失败/请求方法不允许/405 Method Not Allowed
						throw new NotFoundHttpException('请求方法不允许');
						break;
				}
			}
			*/
			return false;
		}
	}
}
?>
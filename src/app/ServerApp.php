<?php 
namespace qing\app;
/**
 * - 服务器应用
 * - 和Web应用不同，它没有http请求处理部分，没有路由解析处理调度部分
 * - 命令行模式:$argc,$argv
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ServerApp extends App implements ServerAppInterface{
	/**
	 * 执行服务器应用
	 *
	 * @param string $ctrl	   执行控制器
	 * @param string $action 执行操作
	 * @param string $module 执行模块
	 */
	public function run(){
		//#前置处理
		if(!$this->applyPreHandle()){
			//前置处理失败|在拦截器中定制错误信息
			return false;
		}
		//#执行主模块
		$res=$this->getMainModule()->beforeMainModule(null);
		if($res===false){
			throw new \qing\exceptions\http\NotFoundHttpException(L()->http_notfound404);
		}
	}
	/**
	 * 执行服务器应用
	 *
	 * @param string $ctrl		执行控制器
	 * @param string $action	执行操作
	 * @param array  $params
	 * @param string $module	执行模块
	 */
	public function runAction($ctrl,$action,array $params=[],$module=MAIN_MODULE){
		$ctrl=$this->getController($ctrl,$module);
		//使用参数执行
		$res =call_user_func_array([$ctrl,$action],$params);
		return $res;
	}
	/**
	 * 创建控制器|可以更改容器
	 *
	 * @param string $ctrlName
	 * @param string $module
	 * @return \qing\controller\Controller
	 */
	public function getController($ctrlName,$module=MAIN_MODULE){
		$module=$this->getModule($module);
		return $module->getController($ctrlName);
	}
}
?>
<?php 
namespace qing\app;
use qing\router\RouteBag;
use qing\exceptions\http\NotFoundHttpException;
/**
 * - 终端/控制台应用
 * - 和Web应用不同，它没有http请求处理部分，没有路由解析处理调度部分
 * - 命令行模式:$argc,$argv
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CliApp extends App{
	use traits\InterceptorTrait;
	/**
	 * 是否经过主模块的beforeMainModule
	 *
	 * @var boolean
	 */
	public $beforeMainModule=true;
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
		$routeBag=$this->parseRoute();
		if(!$routeBag){
			throw new NotFoundHttpException(L()->http_notfound404);
		}
		//定义路由常量
		define('MODULE_NAME'	,$routeBag->module);
		define('CTRL_NAME'		,$routeBag->ctrl);
		define('ACTION_NAME'	,$routeBag->action);
		//#是否经过主模块的beforeMainModule
		if($this->beforeMainModule){
			$beforeModule=$this->getMainModule()->beforeMainModule($routeBag);
		}else{
			$beforeModule=true;
		}
		//#模块前置操作
		if(true===$beforeModule){
			//#控制器返回modelAndView
			$mv=$this->runModuleAndController($routeBag);
		}else{
			//#false/响应
			$mv=$beforeModule;
		}
		if($mv===false){
			throw new NotFoundHttpException(L()->http_notfound404);
		}else{
			//只支持字符串
			echo (string)$mv;
		}
		//#后置处理
		$this->applyPostHandle();
		//#完成后处理
		$this->applyAfterCompletion();
	}
	/**
	 * php -f cli.php "m=main&c=index&a=index"
	 * 
	 * @return \qing\router\RouteBag
	 */
	protected function parseRoute(){
		global $argc,$argv;
		if($argc>1){
			//路由解析
			parse_str((string)$argv[1],$route);
			$module=(string)@$route[RKEY_MODULE];
			$ctrl  =(string)@$route[RKEY_CTRL];
			$action=(string)@$route[RKEY_ACTION];
			if(!$module){
				$module=DEF_MODULE;
			}
			if(!$ctrl){
				$ctrl=DEF_CTRL;
			}
			if(!$action){
				$action=DEF_ACTION;
			}
			return new RouteBag($module,$ctrl,$action);
		}else{
			return false;
		}
	}
	/**
	 * 执行模块和控制器
	 *
	 * @param \qing\router\RouteBag $routeBag
	 * @return \qing\mvc\ModelAndView
	 */
	public function runModuleAndController(RouteBag $routeBag){
		//#主模块或副模块
		$module=$this->getModule($routeBag->module);
		//#模块前置操作
		$res=$module->beforeModule($routeBag);
		if(true!==$res){
			//#false/响应
			return $res;
		}
		$res=$module->runController($routeBag);
		//#模块后置操作
		$module->afterModule($routeBag);
		return $res;
	}
}
?>
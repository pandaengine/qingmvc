<?php 
namespace qing\app;
use qing\facades\Session;
use qing\facades\UrlManager;
use qing\facades\Router;
use qing\exceptions\http\NotFoundHttpException;
use qing\view\V;
use qing\mv\ModelAndView;
use qing\router\RouteBag;
/**
 * Web应用,处理http请求
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class WebApp extends App{
	use traits\InterceptorTrait;
	/**
	 * 应用执行前
	 * 应用初始化完成
	 * 应用执行的第一个事件点
	 *
	 * @var string
	 */
	const E_APP_BEFORE='app.before';
	/**
	 * 应用执行后
	 *
	 * @var string
	 */
	const E_APP_POST='app.post';
	/**
	 * 应用执行结束
	 *
	 * @var string
	 */
	const E_APP_END='app.end';
	/**
	 * 当前路由|转发路由也包括
	 * 只用于webapp
	 * 
	 * @var \qing\router\RouteBag
	 */
	public $ROUTE;
	/**
	 * 是否经过主模块的beforeMainModule
	 *
	 * @var boolean
	 */
	public $beforeMainModule=true;
	/**
	 * 开启session
	 * 只对webapp有效
	 * 
	 * @var string
	 */
	public $sessionOn=true;
	/**
	 * 
	 * @param \qing\router\RouteBag $route
	 */
	public function setRoute(\qing\router\RouteBag $route){
		$this->ROUTE=$route;
		//$this->setModuleName($route->module);
	}
	/**
	 * @return \qing\router\RouteBag
	 */
	public function getRoute(){
		return $this->ROUTE;
	}
	/**
	 * WEB应用运行入口
	 * 处理http请求
	 * 不调用该方法则不处理http请求
	 * 
	 * 运行应用和加载静态应用组件
	 * 派生类可以覆盖该方法去事项更特殊复杂的任务
	 */
	public function run(){
		//预处理/处理http相关的组件
		//初始化URL全局常量/可以在拦截器中使用/在模块配置中使用
		UrlManager::defineGlobalUrl();
		//#自动开启session
		$this->sessionOn && Session::start();
		//#前置处理
		if(!$this->applyPreHandle()){
			//前置处理失败|在拦截器中定制错误信息
			return false;
		}
		//Event::trigger(self::E_APP_BEFORE);
		//#路由解析
		$routeBag=Router::parse();
		if(!$routeBag){
			throw new NotFoundHttpException(L()->http_notfound404);
		}
		$this->setRoute($routeBag);
		//定义路由常量
		define('MODULE_NAME'	,$routeBag->module);
		define('CTRL_NAME'		,$routeBag->ctrl);
		define('ACTION_NAME'	,$routeBag->action);
		//初始化路由URL
		UrlManager::defineRouteUrl($routeBag->module,$routeBag->ctrl,$routeBag->action);
		//
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
		}
		//#后置处理
		$this->applyPostHandle();
		//Event::trigger(self::E_APP_POST);
		//
		if($mv){
			if($mv instanceof \qing\http\Response){
				//#响应|发送响应
				$mv->send();
			}else{
				//#视图渲染
				$this->renderView($mv);
			}
		}
		//#渲染视图完成后处理
		$this->applyAfterCompletion();
		//Event::trigger(self::E_APP_END);
	}
	/**
	 * 执行模块和控制器
	 *
	 * @param \qing\router\RouteBag $routeBag
	 * @return \qing\mvc\ModelAndView
	 */
	public function runModuleAndController(RouteBag $routeBag){
		/*@var $self \qing\app\WebApp */
		$self=$this;
		//#主模块或副模块
		$module=$self->getModule($routeBag->module);
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
	/**
	 * @param $mv
	 */
	public function renderView($mv){
		if(!$mv instanceof ModelAndView){
			if(is_string($mv)){
				//返回字符串型的视图名称|包装成ModelAndView
				$mv=new ModelAndView($mv);
			}else{
				throw new \Exception(L()->view_cannot_parse);
			}
		}
		if($mv->type==ModelAndView::VIEW_MAIN){
			$mv->viewName=$this->getModule(MODULE_NAME)->getViewName($mv->viewName);
		}
		$res=V::render($mv);
		if($res){
			echo (string)$res;
		}
	}
}
?>
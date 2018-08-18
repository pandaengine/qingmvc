<?php 
namespace qing\app;
use qing\com\Component;
use qing\facades\Adapter;
use qing\autoload\AutoLoad;
use qing\view\finder\CtrlFinder;
/**
 * 子模块
 * 应用模块各个部分的路径配置管理
 * 
 * - 模块可以自定义的信息
 * - namespace/view
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Module extends Component implements ModuleInterface{
	/**
	 * 模块的命名空间，默认和主模块一致
	 * 
	 * - 注意不要覆盖了主模块的命名空间映射
	 * - 无法再使用主模块类，无法自动加载|\main\model\Model
	 * - 一般不推荐覆盖主模块/除非模块内部不使用主模块类/只继承主模块的配置
	 *
	 * @var string
	 */
	public $namespace;
	/**
	 * 模块名称
	 *
	 * @var string
	 */
	public $modName;
	/**
	 * 控制器映射
	 * - 自路径或命名空间
	 * - 使用\分隔符，用于命名空间
	 * 
	 * # 数组
	 * ["controller","controllers","controller\site"]
	 * ['controller']
	 * 
	 * # 字符串（移除 ）
	 * 'controller'
	 * 
	 * @var array/string
	 */
	public $ctrlPaths=['controller'];
	/**
	 * 模块目录
	 *
	 * @name modPath basePath
	 * @var string
	 */
	protected $basePath='';
	/**
	 * 视图目录
	 *
	 * @var string
	 */
	protected $viewsPath;
	/**
	 * @return string
	 */
	public function getBasePath(){return $this->basePath;}
	/**
	 * 
	 * @see \qing\app\ModuleInterface::initModule()
	 */
	public function initModule(){
		//#初始化模块的类加载器|副模块才需要|主模块已经在类App初始化了
		AutoLoad::addNamespace($this->namespace,$this->basePath);
		return true;
	}
	/**
	 * 只有当前模块经过该方法
	 * 
	 * @param \qing\router\RouteBag $routeBag
	 * @return boolean
	 */
	public function beforeModule($routeBag){
		return true;
	}
	/**
	 * @param \qing\router\RouteBag $routeBag
	 */
	public function afterModule($routeBag){
	}
	/**
	 * 格式化操作名
	 *
	 * #默认	:index
	 * #1 	:indexAction
	 * #2 	:actionIndex
	 * #3	:_index
	 * #4	:indexAct/indexAc
	 *
	 * @param string $action
	 * @return string
	 */
	public function getActionName($actionName){
		return $actionName;
	}
	/**
	 * 在控制器目录中寻找控制器类名和路径
	 * 
	 * 格式化控制器名|格式化控制器类名
	 * DKEY_CTRL
	 * 
	 * @example \main\controller\IndexController
	 * @example \main\controller\Index
	 * @example \main\controllers\site\Index
	 * @param string $ctrlName
	 * @return string
	 */
	public function getCtrlName($ctrlName){
		$ctrlName=ucfirst($ctrlName);
		//#数组
		foreach($this->ctrlPaths as $dir){
			$ctrlFile=$this->basePath.DS.$dir.DS.$ctrlName.PHP_EXT;
			$ctrlClass=$this->namespace.'\\'.str_replace('/','\\',$dir).'\\'.$ctrlName;
			if(is_file($ctrlFile)){
				//include/避免autoload再次定位
				require_once $ctrlFile;
				return $ctrlClass;
			}
		}
		return false;
	}
	/**
	 * 创建控制器
	 * 可以更改容器
	 *
	 * @param string $ctrlClass
	 * @return \qing\controller\Controller
	 */
	public function getController($class){
		if(!$class){
			return false;
		}
		$dic =$this->getContainer();
		$ctrl=false;
		if($dic->has($class)){
			//#从容器中取得实例|已经绑定到容器
			$ctrl=$dic->get($class);
		}elseif(class_exists($class)){
			//#简单实例化
			$ctrl=new $class();
		}else{
			//#找不到控制器|nullb
		}
		return $ctrl;
	}
	/**
	 * 执行页面控制器|返回modelandview
	 * 
	 * @see \qing\adapter\ControllerAdapter
	 * @param \qing\router\RouteBag $routeBag
	 * @return \qing\mvc\ModelAndView
	 */
	public function runController(\qing\router\RouteBag $routeBag){
		return Adapter::run($routeBag);
	}
	/**
	 * 获取容器
	 * - dic总是从主模块中获取？
	 * - 控制器总是从当前模块中获取
	 * 
	 * @return \qing\di\Container
	 */
	public function getContainer(){
		return com('container');
	}
	/**
	 * 用户会话权限控制
	 *
	 * @return \qing\session\User
	 */
	public function getUser(){
		return com('user');
	}
	/**
	 * 消息提示
	 * - 每个模块都可以自定义
	 * - 主模块和第二模块分开处理
	 * - 返回false使用默认消息组件
	 * 
	 * @return \qing\mv\ModelAndView
	 */
	public function getMessage(array $params){
		return false;
	}
	/**
	 * 
	 * @return $viewsPath
	 */
	public function getViewsPath(){
		return $this->basePath.DS.DKEY_VIEWS;
	}
	/**
	 * 获取主视图模版文件
	 *
	 * @param string $viewName
	 * @return string
	 */
	public function getViewName($viewName){
		return CtrlFinder::getViewName($viewName);
	}
}
?>
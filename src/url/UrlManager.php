<?php
namespace qing\url;
use qing\com\Component;
//use qing\facades\Request;
/**
 * URL管理器
 * 
 * - 别名也应用于__C__/__A__
 * - 注意__APP__是否已经可用
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UrlManager extends Component{
	/**
	 * 是否显示脚本名称
	 * - qingmvc.com/index.php/login
	 * - qingmvc.com/login
	 *
	 * @var boolean
	 */
	public $showScriptName=true;
	/**
	 * 是否显示主机域名
	 * - http://qingmvc.com/index.php/login
	 * - /index.php/login
	 * 
	 * - http://qingmvc.com/comment
	 * - /comment
	 * 
	 * @var boolean
	 */
	public $showHostName=true;
	/**
	 * 定义显示文件后缀 
	 * - qingmvc.com/index.php/login.html
	 * - qingmvc.com/index.php/login
	 *
	 * @var string
	 */
	public $urlSuffix='';
	/**
	 * 根路径
	 *
	 * @var string
	 */
	public $rootUrl;
	/**
	 * 路由创建器
	 * 
	 * @var \qing\url\creators\CreatorInterface
	 */
	protected $_creators;
	/**
	 * @see \qing\com\Component::initComponent()
	 */
	public function initComponent(){
	}
	/**
	 * 设置生成器
	 *
	 * @param CreatorInterface $creator
	 */
	public function pushCreator(UrlInterface $creator){
		$this->_creators[]=$creator;
	}
	/**
	 * 定义全局url
	 * 
	 * __HOME__>>__ROOT__>>__APP__>>__PATH__>>__URL__
	 * 
	 */
	public function defineGlobalUrl(){
		//#host
		if($this->showHostName){
			//显示主机域名
			//$_SERVER['HTTP_HOST']/Request::getHttpHost();
			$host=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
		}else{
			//不显示主机域名
			$host='';
		}
		
		//#rootpath
		//$rootpath=Request::getRootpath();
		$rootpath=dirname($_SERVER['SCRIPT_NAME']);
		if($rootpath=='/' || $rootpath==DS){
			$rootpath='';
		}
		$__root__=$host.$rootpath;
		
		//#scriptname
		if(!$this->showScriptName){
			//#不显示脚本名称 /qingmvc
			$__app__=$__root__;
		}else{
			//#显示脚本名称 /qingmvc/index.php
			//$scriptName=Request::getScriptBasename();
			$scriptName=basename($_SERVER['SCRIPT_NAME']);
			$__app__=rtrim($__root__,'/').'/'.$scriptName;
		}
		// /public / 可以为空，但不能是/,避免 //static错误路径；用于组建url __ROOT__+'/abc'
		defined('__ROOT__') or define('__ROOT__',$__root__);
		// /public/admin.php
		defined('__APP__') 	or define('__APP__'	,$__app__);
		// 不会为空，空为/ ;只用于首页url
		defined('__HOME__') or define('__HOME__',$__root__?$__root__:'/');
		
		if(!$this->rootUrl){
			$this->rootUrl=__APP__;
		}
	}
	/**
	 * 生成路由链接
	 * $_SERVER['SCRIPT_NAME']|当前请求的php脚本名称路径
	 *
	 * 生成控制器和操作全局链接
	 * - 包含文件名 /index.php/index/detail
	 * - 不包含文件名 /index/detail
	 *
	 * ##	DS 服务器路径分隔符 win:\ linux: /
	 * ##	浏览器分隔符均为 /
	 * 
	 * @param string $module
	 * @param string $ctrl
	 * @param string $action
	 */
	public function defineRouteUrl($module,$ctrl,$action){
		$module==MAIN_MODULE && $module='';
		//#当前模块url
		define('__M__',$this->create($module,'',''));
		//#当前控制器url
		define('__C__',$this->create($module,$ctrl,''));
		//#当前操作url
		define('__A__',$this->create($module,$ctrl,$action));
	}
	/**
	 * 创建url
	 * 根据模块，控制器，操作各个部分生成url
	 *
	 * get : index.php?m=member&c=Index&a=login
	 * path: index.php/.member/index/login
	 * rpath: index.php?r=/.member/index/login
	 *
	 * @param string $module 	模块
	 * @param string $ctrl 		控制器
	 * @param string $action 	操作
	 * @param array  $params 	附加参数
	 * @return string
	 */
	public function create($module,$ctrl,$action='',array $params=[]){
		if(!$this->_creators){
			return '';
		}
		$url='';
		/*@var $c \qing\url\creators\CreatorInterface */
		foreach((array)$this->_creators as $c){
			$url=$c->create($module,$ctrl,$action,$params);
			if($url!==false){
				//创建成功
				break;
			}
		}
		return $this->rootUrl.$url;
	}
}
?>
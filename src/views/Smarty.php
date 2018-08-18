<?php
namespace qing\views;
use qing\com\Component;
use qing\view\ViewInterface;
use qing\mv\ModelAndView;
/**
 * smarty模版引擎组件
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Smarty extends Component implements ViewInterface{
	/**
	 * smarty实例
	 *
	 * @var \Smarty
	 */
	protected $smarty;
	/**
	 * smarty类文件
	 * - 填写则包含
	 * - 可以手动加载/composer加载等
	 *
	 * @var string
	 */
	public $smartyFile;
	/**
	 * smarty类名
	 *
	 * @var string
	 */
	public $smartyClass='\Smarty';
	/**
	 * 模版目录/默认从模块中获取
	 *
	 * @var string
	 */
	public $templateDir;
	/**
	 * 缓存目录
	 * 
	 * @var string
	 */
	public $cacheDir;
	/**
	 * 编译目录
	 *
	 * @var string
	 */
	public $compileDir;
	/**
	 * 配置目录
	 *
	 * @var string
	 */
	public $configDir;
	/**
	 * 插件目录
	 *
	 * @var string
	 */
	public $pluginsDir;
	/**
	 * 是否debug
	 *
	 * @var string
	 */
	public $debugging=false;
	/**
	 * 强制编译
	 *
	 * @var string
	 */
	public $force_compile=false;
	/**
	 * 是否缓存
	 *
	 * @var string
	 */
	public $caching=true;
	/**
	 * 缓存有效期
	 *
	 * @var string
	 */
	public $cache_lifetime=120;
	/**
	 * 组件初始化
	 * 实例化smarty
	 * 
	 * @see \qing\com\Component::initComponent()
	 */
	public function initComponent(){
		$filename=$this->smartyFile;
		if($filename){
			require_once $filename;
		}
		$className=$this->smartyClass;
		if(!class_exists($className)){
			throw new \qing\exceptions\NotfoundClassException($className);
		}
		$this->smarty=$smarty=new $className();
		$this->initSmarty();
	}
	/**
	 * 设置smarty实例
	 *
	 * @see \Smarty
	 */
	protected function initSmarty(){
		$runtimePath =APP_RUNTIME.DS.'~smarty';
		//模版目录
		if($this->templateDir===null){
			$this->templateDir=mod()->getViewsPath();
		}
		//配置目录
		if(!$this->configDir){
			$this->configDir=$this->templateDir.'/configs';
		}
		//缓存目录
		if($this->cacheDir===null){
			$this->cacheDir=$runtimePath.'/cache';
		}
		//编译目录
		if($this->compileDir===null){
			$this->compileDir=$runtimePath.'/templates_c';
		}
		$smarty=$this->smarty;
		$smarty->setTemplateDir($this->templateDir);
		$smarty->setConfigDir($this->configDir);
		$smarty->setCacheDir($this->cacheDir);
		$smarty->setCompileDir($this->compileDir);
		//插件目录
		if($this->pluginsDir){
			$smarty->setPluginsDir($this->pluginsDir);
		}
		$smarty->force_compile  = $this->force_compile;
		$smarty->debugging 		= $this->debugging;
		$smarty->caching 		= $this->caching;
		$smarty->cache_lifetime = $this->cache_lifetime;
	}
	/**
	 * 返回smarty实例
	 *
	 * @return \Smarty
	 */
	public function getSmarty(){
		return $this->smarty;
	}
	/**
	 * 视图渲染
	 * 
	 * @see \qing\view\ViewInterface::render()
	 */
	public function render(ModelAndView $mv){
		$smarty=$this->smarty;
		$smarty->assign($mv->vars);
		return $smarty->fetch($mv->viewName);
	}
}
?>
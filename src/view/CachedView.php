<?php
namespace qing\view;
/**
 * - 支持缓存的视图解析器
 * - 要配置视图编译组件view.compiler
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CachedView extends View implements ViewInterface{
	/**
	 * debug/总是编译
	 * 
	 * @var string
	 */
	public $debug=false;
	/**
	 * 使用的编译器
	 *
	 * @var string
	 */
	public $compiler='view.compiler';
	/**
	 *
	 * @see \qing\view\View::render()
	 */
	public function render(\qing\mv\ModelAndView $mv){
		$viewFile =$this->getViewFile($mv);
		$cacheFile=$this->getCacheFile($mv->viewName,$viewFile);
		
		//#检测缓存是否有效
		if(!$this->checkCache($viewFile,$cacheFile)){
			//#缓存失效，编译模版
			com($this->compiler)->compile($viewFile,$cacheFile);
		}
		
		//渲染缓存
		$content=$this->renderFile($cacheFile,$mv->vars,$mv->capture);
		//渲染编译后的视图缓存文件
		return $content;
	}
	/**
	 * 检测编译缓存文件是否过期缓存有效性
	 * 如果未过期则直接载入/若过期则重新编译
	 *
	 * 未过期  直接载入	返回 true
	 * 过期      重新编译      	返回false
	 *
	 * filemtime : Gets file modification time |获取文件上次修改时间
	 *
	 * @param string $viewFile
	 * @param string $cacheFile
	 * @return boolean 缓存是否有效
	 */
	protected function checkCache($viewFile,$cacheFile){
		if($this->debug){
			//debug/总是编译
			return false;
		}
		if(!is_file($cacheFile)){
			//编译缓存不存在 重新编译
			return false;
		}elseif(filemtime($viewFile)>filemtime($cacheFile)){
			//模板文件如果更改过,则缓存需要更新，重新编译
			return false;
		}
		//缓存有效，返回模版缓存路径
		return true;
	}
	/**
	 * 缓存文件
	 * 
	 * bugfix:路径加上布局|避免同一个方法使用不同布局但是缓存同名覆盖问题|同一个主视图文件使用不同布局的覆盖问题
	 * bugfix:路径加上模块|避免不同模块控制和操作同名|模块不同视图文件路径不同
	 * 
	 * @param string $viewName
	 * @param string $viewFile
	 * @return string
	 */
	protected function getCacheFile($viewName,$viewFile){
		//#避免不同模块路径相同被覆盖
		//$viewId=substr(md5($viewFile),-8);
		$viewId=md5($viewFile);
		$cachePath=APP_RUNTIME.DS.'~views';
		return $cachePath.DS.$viewName.'.'.$viewId.VIEW_SUFFIX;
	}
}
?>
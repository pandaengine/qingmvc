<?php
namespace qing\view;
use qing\com\Component;
use qing\exceptions\NotfoundFileException;
/**
 * 基础视图解析器
 * - 只支持php标签
 * - 支持块section块功能，可以实现类似布局的功能
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class View extends Component implements ViewInterface{
	/**
	 * 视图目录
	 *
	 * @var string
	 */
	public $viewPath='';
	/**
	 * 可重用块的标识符ID缓存栈
	 *
	 * @var array
	 */
	protected $sectionIds=[];
	/**
	 * 可重用块的渲染后的视图缓存栈
	 *
	 * @var array
	*/
	protected $sections=[];
	/**
	 * @see \qing\com\ComponentInterface::initComponent()
	 */
	public function initComponent(){
		
	}
	/**
	 * @see \qing\view\ViewInterface::render()
	 */
	public function render(\qing\mv\ModelAndView $mv){
		$viewFile=$this->getViewFile($mv);
		//不支持布局
		//$layout=$mv->layout;
		$vars	 =$mv->vars;
		return $this->renderFile($viewFile,$vars,$mv->capture);
	}
	/**
	 * 渲染指定文件|只支持php标签
	 * ---
	 * 注意：需要严格控制该方法暴露的变量
	 * - 该方法暴露的局域变量在视图中都是可见的。
	 * - 视图作用域其实就是该方法的作用域，视图可时候使用$this当前视图对象
	 * - 视图文件中 $this=(object)View
	 * ---
	 * 渲染注意：当渲染视图时异常，不会捕获返回会直接输出
	 * 
	 * @param string 	$_viewFile_     [视图模版文件路径|编译后的模版缓存]
	 * @param array  	$_vars_     	[应用到视图的数据]
	 * @param boolean 	$_return_   	[捕获渲染结果返回还是直接输出]
	 * @return string          			[渲染结果]
	 * @throws QException
	 * @access public 开放给Widget调用
	 */
	protected function renderFile($_viewFile_,array $_vars_=array(),$_return_=false){
		if($_return_){
			//#捕获渲染视图内容返回
			//捕获页面缓存
			ob_start();
			ob_implicit_flush(0);
		}else{
			unset($_return_);
		}
		//模板阵列分解成为独立变量
		extract($_vars_,EXTR_OVERWRITE);
		//在渲染视图前，销毁暴露的变量
		unset($_vars_);
		//直接载入PHP模板
		//视图文件里的作用域和当前位置一致，可使用$this
		if(!is_file($_viewFile_)){
			throw new NotfoundFileException($_viewFile_);
		}
		include $_viewFile_;
		//
		if(isset($_return_) && $_return_){
			// 获取并清空缓存
			$_content_=ob_get_clean();
			// 输出模板文件
			return $_content_;
		}
		return '';
	}
	/**
	 * @param \qing\mv\ModelAndView $mv
	 * @return string
	 */
	public function getViewFile(\qing\mv\ModelAndView $mv){
		if($mv->viewPath){
			$viewPath=$mv->viewPath;
		}else{
			//$viewPath=$this->viewPath;
			$viewPath=mod()->getViewsPath();
		}
		$viewFile=$viewPath.DS.$mv->viewName.VIEW_SUFFIX;
		$realFile=realpath($viewFile);
		if(!$realFile){
			throw new NotfoundFileException($viewFile);
		}
		return $realFile;
	}
	/**
	 * - 创建一个页面内的可复用/可被布局和视图调用的块状区域，
	 * - 捕获视图中一小块渲染解析后的视图
	 * - 需要先创建才能使用
	 *
	 * @param string $id 标识符
	 */
	protected function sectionBegin($id){
		//追加到尾部
		array_push($this->sectionIds,$id);
		//开始捕获页面缓存
		ob_start();
		ob_implicit_flush(0);
	}
	/**
	 * 结束区域
	 * 结束捕获，返回数据
	 * array_pop() 函数删除数组中的最后一个元素,并返回
	 * 
	 * 注意:
	 * - 不可以嵌套
	 * - 嵌套会导致数据丢失
	 * 
	 * @throws \Exception
	 * @return string
	 */
	protected function sectionEnd(){
		//从尾部删除
		$id=array_pop($this->sectionIds);
		if($id==null){
			throw new \Exception('section结束异常，不可嵌套，必须成对出现');
		}
		return $this->sections[$id]=ob_get_clean();
	}
	/**
	 * 获取某个缓存的块
	 * 注意：先有捕获，才能使用
	 * 
	 * @param string $id
	 * @param string $clear 使用后清除
	 * @return string
	 */
	protected function section($id,$clear=true){
		if(isset($this->sections[$id])){
			$content=$this->sections[$id];
			if($clear){ unset($this->sections[$id]); }
			return $content;
		}else{
			return '';
		}
	}
}
?>
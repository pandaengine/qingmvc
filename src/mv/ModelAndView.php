<?php
namespace qing\mv;
/**
 * - 携带模型数据/数据载体
 * - 视图模型数据和视图文件
 * - 控制器内的模版数据载体
 * - 控制器和视图数据包角色
 * - 支持链操作
 * 
 * @name ViewBag VarAndView DataAndView
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ModelAndView{
	/**
	 * 视图类型
	 * 
	 * VIEW_MAIN: 主视图
	 * VIEW_WIDGET: 小部件
	 * VIEW_REAL: 真实路径
	 * 
	 * @var string
	 */
	const VIEW_MAIN		=1;
	const VIEW_WIDGET	=2;
	const VIEW_MSG		=3;
	const VIEW_REAL		=4;
	/**
	 * 视图类型
	 * - 主视图：view
	 * - 小部件：widget
	 * - 插件：   plugin
	 *
	 * @var string
	 */
	public $type=self::VIEW_MAIN;
	/**
	 * 视图名称，视图文件
	 *
	 * @var string
	 */
	public $viewName='';
	/**
	 * 视图目录
	 *
	 * @var string
	 */
	public $viewPath='';
	/**
	 * 视图数据，模版数据
	 *
	 * @name params
	 * @var array
	 */
	public $vars=[];
	/**
	 * 是否捕获返回
	 * 
	 * @var boolean
	 */
	public $capture=true;
	/**
	 * - 为当前渲染指定解析器|否则使用全局配置
	 *
	 * @name resolver
	 * @var string
	 */
	public $render;
	/**
	 * 构造函数
	 *
	 * @param string $viewName 模版文件
	 * @param array  $vars     模版变量
	 */
	public function __construct($viewName='',array $vars=[]){
		$this->viewName=$viewName;
		$this->vars    =$vars;
	}
	/**
	 * 模板变量赋值/注入模版变量/分配变量
	 * 
	 * @param string|array $key  变量名称
	 * @param mixed $value 变量值
	 * @return $this
	 */
	public function assign($key,$value){
		$this->vars[$key]=$value;
		return $this;
	}
	/**
	 * 获取模版变量
	 *
	 * @return $this;
	 */
	public function vars(array $vars){
		$this->vars=array_merge($this->vars,$vars);
		return $this;
	}
	/**
	 * 配置视图名称
	 *
	 * @param string $viewName
	 * @return $this
	 */
	public function viewName($viewName){
		$this->viewName=$viewName;
		return $this;
	}
	/**
	 *
	 * @param string $viewPath
	 * @return $this
	 */
	public function viewPath($viewPath){
		$this->viewPath=$viewPath;
		return $this;
	}
	/**
	 * @param string $type
	 * @return $this
	 */
	public function type($type){
		$this->type=$type;
		return $this;
	}
	/**
	 * @param string $capture
	 * @return $this
	 */
	public function capture($capture){
		$this->capture=$capture;
		return $this;
	}
}
?>
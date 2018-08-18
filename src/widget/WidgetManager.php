<?php
namespace qing\widget;
use qing\com\Component;
use qing\exceptions\NotfoundClassException;
use qing\facades\Container;
use qing\exceptions\NotmatchClassException;
/**
 * 小部件管理器
 * 只在主模块支持，简单才是硬道理
 * 
 * @name U V W 快捷帮助类
 * @name WidgetManager
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class WidgetManager extends Component{
	/**
	 * 目录
	 *
	 * @var string
	 */
	public $widgetDir='widget';
	/**
	 * 视图目录
	 *
	 * @var string
	 */
	public $viewDir='_widget';
	/**
	 * @var array
	 */
	protected $_widgets=[];
	/**
	 * @see \qing\com\ComponentInterface::initComponent()
	 */
	public function initComponent(){
	}
	/**
	 * 创建一个小部件并显示或返回渲染后的视图
	 *
	 * @param string $name 小部件标识符
	 * @param mixed  $data 传入小部件渲染的数据
	 * @param string $module 工作基于的模块
	 */
	public function run($name,$data=null,$module=null){
		!$module && $module=MAIN_MODULE;
		$widget=$this->getWidget($name,$module);
		return $widget->run($data);
	}
	/**
	 * 小部件视图目录
	 *
	 * @param string $module
	 * @return string
	 */
	public function getViewPath($module){
		return mod($module)->getViewsPath().DS.$this->viewDir;
	}
	/**
	 * 类名
	 *
	 * @param string $widget
	 * @param string $module
	 * @return string
	 */
	public function getName($widget,$module){
		if($module){
			$ns=mod($module)->namespace;
		}else{
			$ns=APP_NAMESPACE;
		}
		return $ns.'\\'.$this->widgetDir.'\\'.ucfirst($widget);
	}
	/**
	 * 创建小部件实例
	 *
	 * @param string $name 小部件标识符
	 * @param string $module
	 * @return Widget
	 */
	public function getWidget($name,$module){
		$id=strtolower($module.'@'.$name);
		if(isset($this->_widgets[$id])){
			return $this->_widgets[$id];
		}
		$class=$this->getName($name,$module);
		if(!class_exists($class)){
			throw new NotfoundClassException($class);
		}
		if(Container::has($class)){
			//#从容器中取得实例
			$widget=Container::get($class);
		}elseif(class_exists($class)){
			//#简单实例化
			$widget=new $class();
		}else{
			//#找不到
			throw new NotFoundWidgetException("{$name} ({$class})");
		}
		if(!$widget instanceof WidgetInterface){
			throw new NotmatchClassException(get_class($widget),WidgetInterface::class);
		}
		/*@var $widget \qing\widget\Widget */
		$widget->setWidgetName($name);
		$widget->setModuleName($module);
		return $this->_widgets[$id]=$widget;
	}
}
?>
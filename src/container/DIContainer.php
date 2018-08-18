<?php
namespace qing\container;
/**
 * - 自动注入DI容器
 * - 配置映射注入maps
 * - 支持构造函数依赖自动解析注入和set方法属性自动解析注入
 * 
 * 自动注入容器
 * 
 * - 自动解析构造函数参数依赖注入
 * - 自动解析set函数参数依赖注入
 * 
 * @deprecated 直接使用映射配置即可，不需要有构造函数或set方法等 ，增加了代码量，复杂度，耦合性
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class DIContainer extends Container{
	/**
	 * 自动注入解析器
	 *
	 * @var AutoInjector
	 */
	protected $_autoInjector;
	/**
	 */
	public function __construct(){
		//$this->initComponent();
	}
	/**
	 *
	 * @see \qing\com\ComponentInterface::initComponent()
	 */
	public function initComponent(){
		$this->_autoInjector=new AutoInjector($this);
	}
	/**
	 * 创建服务
	 *
	 * @param string $service 服务配置
	 * @return mixed
	 */
	public function create($service){
		$isArray=is_array($service);
		//#类名
		if($isArray){
			//#数组
			if(!isset($service['class'])){
				throw new \qing\exceptions\NotfoundItem('class');
			}
			$class=(string)$service['class'];
			unset($service['class']);
		}else{
			//#字符串
			$class=(string)$service;
			$service=[];
		}
		//#创建实例，并解析注入依赖
		$instance=$this->_autoInjector->createInstance($class);
		if($service){
			//注入依赖属性
			$this->setDis($instance,$service);
		}
		return $instance;
	}
	/**
	 * - 用于自动注入解析的属性：根据set方法参数依赖自动注入
	 * - 普通依赖实例属性：
	 *
	 * 'mCat'=>
	 * [
	 * 		'prop01'=>'::di',
	 * 		'prop02'=>'mUser'
	 * ]
	 *
	 * @param array $dis
	 * @return array
	 */
	public function setDis($instance,array $dis){
		foreach($dis as $diName=>$diValue){
			//字符串
			$diValue=(string)$diValue;
			if($diValue=='::di'){
				//#调用依赖注入set方法，不设置属性值
				//#自动注入依赖|从set方法参数得依赖类或接口注入
				$this->_autoInjector->setProperty($instance,$diName);
			}else{
				//#普通实例属性
				$instance->$diName=$this->get($diValue);
			}
		}
	}
}
?>
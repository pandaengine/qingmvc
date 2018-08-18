<?php
namespace qing\container;
/**
 * 自动注入解析器
 * 
 * - 自动解析构造函数，参数类型约束，依赖注入
 * - 自动解析set函数，参数类型约束，依赖注入
 * - 依赖映射管理注入，普通容器默认支持
 * ---
 * - 不推荐set方法注入：要写一系列的set方法，臃肿
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class AutoInjector implements AutoInjectorInterface{
	/**
	 * @var Container
	 */
	protected $container;
	/**
	 * 
	 * @param Container $container
	 */
	public function __construct(Container $container){
		$this->container=$container;
	}
	/**
	 * 使用set方法的参数依赖自动注入属性
	 *
	 * @param string $propName
	 * @param mixed  $instance
	 */
	public function setProperty($instance,$propName){
		$setterName='set'.ucfirst($propName);
		if(!method_exists($instance,$setterName)){
			throw new \qing\exceptions\NotfoundMethodException(get_class($instance).'::'.$propName);
		}
		//成员方法反射对象
		$refMethod=new \ReflectionMethod($instance,$setterName);
		if($refMethod->isPublic() || $refMethod->isProtected()){
			//#非public方法或静态方法禁止访问
			//#取得依赖|只取一个参数
			$parameters	 =$refMethod->getParameters();
			$dependencies=$this->getDependencies($parameters);
			//#执行方法
			$refMethod->invokeArgs($instance,$dependencies);
		}
	}
	/**
	 * 创建实例，并解析构造函数约束，注入依赖
	 * 
	 * @log 2016.04.04  剔除传入参数支持
	 * @param string $className 类名称
	 * @return mixed
	 */
	public function createInstance($className){
		$refClass=new \ReflectionClass($className);
		if(!$refClass->isInstantiable()){
			throw new \Exception(L()->class_not_instantiable.$className);
		}
		//类控制器|ReflectionMethod
		/*@var $constructor \ReflectionMethod */
		$constructor=$refClass->getConstructor();
		if(!$constructor || 0==$constructor->getNumberOfParameters()){
			//#无构造函数或无参数，不解析构造函数依赖
			//没有构造函数|构造函数参数个数为零&直接实例化类返回
			return new $className();
		}else{
			//#解析构造函数依赖并注入
			//构造函数依赖注入的变量类|ReflectionParameter
			$consParameters=$constructor->getParameters();
			//解析构造函数参数的依赖
			$consDependencies=$this->getDependencies($consParameters);
			//给定参数创建类实例
			return $refClass->newInstanceArgs($consDependencies);
		}
	}
	/**
	 * 构造函数的参数依赖|set方法的参数依赖
	 *
	 * @param array $parameters
	 * @return array
	 */
	protected function getDependencies(array $parameters){
		/*@var $parameter \ReflectionParameter */
		$list=array();
		foreach($parameters as $parameter){
			//参数对应的反射类|参数约束类类型
			$parameterClass=$parameter->getClass();
			if($parameterClass===null){
				//#没有"类"类型约束
				$list[]=$this->getDependencyByNonClass($parameter);
			}else{
				//#类名不为空，作为类解析
				$list[]=$this->getDependencyByClass($parameter);
			}
		}
		return $list;
	}
	/**
	 * 解析依赖，没有类依赖的参数
	 * 如果有默认值则直接返回默认值|否则抛出异常
	 *
	 * @param  \ReflectionParameter $parameter
	 * @return mixed
	 */
	protected function getDependencyByNonClass(\ReflectionParameter $parameter){
		if($parameter->isDefaultValueAvailable()){
			//#如果有默认值则返回默认值
			return $parameter->getDefaultValue();
		}
		//$parameter->getDeclaringClass()->getName()|参数所在的类
		throw new \qing\exceptions\NotfoundMethodParameterException(
				$parameter->getDeclaringClass()->getName(),
				$parameter->getDeclaringFunction()->getName(),
				$parameter->getName()
		);
	}
	/**
	 * 解析依赖，参数约束为类
	 * 
	 * - 类约束
	 * - 接口约束
	 * - 从容器中获取实例
	 * - 接口的时候，容器需要绑定接口和类映射
	 *
	 * @param \ReflectionParameter $parameter
	 * @return mixed
	 */
	protected function getDependencyByClass(\ReflectionParameter $parameter){
		//参数约束的类名称或者接口名称
		$className=$parameter->getClass()->getName();
		//从容器中获取实例
		return $this->container->get($className);
		//如果不存在直接创建?
	}
}
?>
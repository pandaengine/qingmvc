<?php 
namespace qing\utils;
use qing\exceptions\NotfoundItem;
use qing\exceptions\NotfoundClassException;
/**
 * 实例创建器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Instance{
	/**
	 * 单例装载后的实例
	 *
	 * @var array
	 */
	public static $_instances=[];
	/**
	 * 根据给定的信息创建和初始化实例
	 * class_exists($class, false) [autoload 参数设为 FALSE]
	 * 
	 * @param mixed $config 类名或包含类名和类文件的数组
	 * @param boolean $setProps 是否注入属性
	 * @return object
	 */
	public static function create(&$config,$setProps=true){
		if(is_array($config)){
			//#数组
			if(!isset($config['class'])){
				throw new NotfoundItem('class');
			}
			$class=$config['class'];
			unset($config['class']);
			//#类文件
			if(isset($config['classFile'])){
				//直接导入类文件
				require_once $config['classFile'];
				unset($config['classFile']);
			}
		}else if(is_string($config)){
			//#字符串
			$class=$config;
			$config=[];
		}else if($config instanceof \Closure){
			//#匿名函数
			return call_user_func($config);
		}else{
			throw new \Exception("can not create instance");
		}
		if(!class_exists($class)){
			throw new NotfoundClassException($class);
		}
		$instance=new $class();
		//往实例里注入配置属性
		if($setProps && $config){
			static::setProps($instance,$config,false);
		}
		return $instance;
	}
	/**
	 * 注入类属性值
	 *
	 * @param object 	$object
	 * @param array 	$props
	 * @param boolean 	$setFirst
	 */
	public static function setProps($object,array $props,$setFirst=false){
		if($setFirst){
			//#开启set方法注入
			foreach ($props as $name=>$value){
				$setter='set'.ucfirst($name);
				if(method_exists($object,$setter)){
					$object->$setter($value);
				}else{
					$object->$name=$value;
				}
			}
		}else{
			//#
			foreach ($props as $name=>$value){
				$object->$name=$value;
			}
		}
	}
	/**
	 * 创建单例
	 *
	 * @name singleton
	 * @param string $className
	 * @return  object
	 */
	public static function sgt($className){
		if(isset(self::$_instances[$className])){
			return self::$_instances[$className];
		}else{
			return self::$_instances[$className]=new $className();
		}
	}
	/**
	 * 创建单例
	 *
	 * @name sgt closure
	 * @param string   $id
	 * @param \Closure $creator
	 * @return object
	 */
	public static function sgtc($id,\Closure $creator){
		if(isset(self::$_instances[$id])){
			return self::$_instances[$id];
		}else{
			return self::$_instances[$id]=call_user_func($creator);
		}
	}
}
?>
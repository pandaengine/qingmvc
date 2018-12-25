<?php
namespace qing\facades;
use qing\exceptions\NotfoundMethodException;
/**
 * - 组件快速访问门面系统
 * - 获取的是组件
 *
 * static::getName() 可以调用子类覆盖的静态函数self::则不能!
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Facade{
	/**
	 * 已绑定实例
	 * - 假如名称改变
	 * - 绑定多个实例
	 * 
	 * # 简单起见，只允许绑定一次一个一种组件实例
	 * - 缓存实例
	 * 
	 * @var array/object
	 */
	protected static $_instance;
	/**
	 * 获取注册的组件名称，子类必须继承实现该方法
	 *
	 * @return string
	 */
	protected static function getName(){
		return '';
	}
	/**
	 * 从组件容器中获取对应实例
	 *
	 * @param string $name
	 * @return mixed
	 */
	public static function getInstance(){
		return com(static::getName());
		/*
		if(static::$_instance){
			return static::$_instance;
		}
		//缓存到实例
		return static::$_instance=coms()->get(static::getName());
		*/
	}
	/**
	 * 动态处理，当调用不存在的静态方法时触发该魔术方法
	 * 
	 * @param string $method        	
	 * @param array $args        	
	 * @return mixed
	 */
	public static function __callStatic($method,$args){
		$instance=static::getInstance();
		if(!method_exists($instance, $method)){
			throw new NotfoundMethodException(get_class($instance),$method);
		}
		switch(count($args)){
			case 0:
				return $instance->$method();
			case 1:
				return $instance->$method($args[0]);
			case 2:
				return $instance->$method($args[0],$args[1]);
			case 3:
				return $instance->$method($args[0],$args[1],$args[2]);
			case 4:
				return $instance->$method($args[0],$args[1],$args[2],$args[3]);
			default:
				return call_user_func_array(array($instance,$method),$args);
		}
	}
}
?>
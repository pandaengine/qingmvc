<?php
namespace qing\utils;
/**
 * 代理类，代理处理访问和写入，可以懒加载被代理者的实例
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
abstract class ProxyClass{
	/**
	 * @var \Object
	 */
	protected $object;
	/**
	 */
	abstract public function getObject();
	/**
	 * @param string $name  属性的名称
	 * @param mixed  $value 属性的值
	 */
	public function __set($name,$value){
		$this->getObject()->$name=$value;
	}
	/**
	 * @param string $name
	 */
	public function __get($name){
		return $this->getObject()->$name;
 	}
 	/**
 	 * @param string $name	方法名称
 	 * @param array  $args 	方法参数|$args
 	 * @return null
 	 */
 	public function __call($name,$args){
 		return call_user_func_array([$this->getObject(),$name],$args);
 	}
	/**
	 * @param string 属性名称
	 */
	public function __isset($name){
		throw new \Exception( L()->class_property_notfound.':'.get_class($this).'->'.$name );
	}
	/**
	 * @param string 属性名称
	 */
	public function __unset($name){
		throw new \Exception( L()->class_property_notfound.':'.get_class($this).'->'.$name );
	}
	/**
	 * @param string $name
	 * @param array  $args
	 */
 	public static function __callStatic($name,array $args){
 		return call_user_func_array([$this->getObject().'::'.$name],$args);
 	}
 	/**
 	 * 当调用 var_export() 导出类时，此静态 方法会被调用。
 	 * 
 	 * @link http://php.net/manual/zh/language.oop5.magic.php#object.set-state
 	 */
 	public function __set_state(){
 		dump(__METHOD__);
 	}
 	/**
 	 * 当尝试以调用函数的方式调用一个对象时，__invoke() 方法会被自动调用。
 	 *
 	 * @link http://php.net/manual/zh/language.oop5.magic.php#object.set-state
 	 */
 	public function __invoke(){
 		dump(__METHOD__);
 	}
}
?>
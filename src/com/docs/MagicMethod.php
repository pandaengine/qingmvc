<?php
namespace qing\com;
/**
 * 魔术方法
 * Magic methods
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MagicMethod_OFF{
	/**
	 * 设置组件的属性,当给不存在的对象属性赋值的时候，触发此方法
	 * $this->name=$value;
	 * $this->setName($value);
	 * 在给不可访问属性赋值时，__set() 会被调用。
	 * ---
	 * @param string $name  属性的名称
	 * @param mixed  $value 属性的值
	 */
	public function __set($name,$value){
		$setter='set'.ucfirst($name);
		if(method_exists($this,$setter)){
			//使用setValue()方法注入属性
			$this->$setter($value);
			return true;
		}
		throw new \Exception( L()->class_property_notfound.':'.get_class($this).'->'.$name );
		return false;
	}
	/**
	 * 返回组件的属性值,如果属性不存在或不能访问，检测是否存在get方法
	 * $this->name;
	 * $this->getName();
	 * 读取不可访问属性的值时，__get() 会被调用。
	 * ---
	 * @param string $name 属性的名称
	 */
	public function __get($name){
		$getter='get'.ucfirst($name);
		if(method_exists($this,$getter)){
			//使用getName()方法获取属性
			return $this->$getter();
		}
		throw new \Exception( L()->class_property_notfound.':'.get_class($this).'->'.$name );
		return false;
 	}
 	/**
 	 * 魔术方法|当调用一个不存在的成员方法时触发
 	 * ---
 	 * @param string $name	方法名称
 	 * @param array  $args 	方法参数|$args
 	 * @return null
 	 */
 	public function __call($name,$args){
 		//debug_print_backtrace();
 		//dump(get_defined_vars());exit();
 		throw new \Exception( L()->class_method_notfound.':'.get_class($this).'->'.$name );
 		return false;
 	}
	/**
	 * 检测属性
	 * 当对不可访问属性调用 isset() 或 empty() 时，__isset() 会被调用。
	 * 类属性不可访问.检测
	 * 
	 * @param string 属性名称
	 */
	public function __isset($name){
		throw new \Exception( L()->class_property_notfound.':'.get_class($this).'->'.$name );
	}
	/**
	 * 删除属性
	 * 当对不可访问属性调用 unset() 时，__unset() 会被调用。
	 * 类属性不可访问.删除
	 * 
	 * @param string 属性名称
	 */
	public function __unset($name){
		throw new \Exception( L()->class_property_notfound.':'.get_class($this).'->'.$name );
	}
	/**
	 * 静态方法不存在|self::
	 * 
	 * @param string $name
	 * @param array  $args
	 */
 	public static function __callStatic($name,array $args){
 		throw new \Exception( L()->class_static_method_notfound.':'.get_class($this).'->'.$name );
 	}
 	/**
 	 * 转换为字符串时触发该方法
 	 * __toString() 方法用于一个类被当成字符串时应怎样回应。
 	 * 例如 echo $obj; 应该显示些什么。
 	 * 此方法必须返回一个字符串，否则将发出一条 E_RECOVERABLE_ERROR 级别的致命错误。
 	 * 
 	 */
 	public function __toString(){
 		return get_class($this);
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
 	
 	//---
 	
 	/**
 	 * 是否能获取属性
 	 * @param  $name
 	 */
 	public function _getEnable($name){
 		return method_exists($this,'get'.ucfirst($name));
 	}
 	/**
 	 * 是否能设置属性
 	 * @param  $name
 	 */
 	public function _setEnable($name){
 		return method_exists($this,'set'.ucfirst($name));
 	}
 	/**
 	 * 简单漂亮的格式化
 	 */
 	public function _dump_pretty(){
 		objectPretty($this);
 	}
}
?>
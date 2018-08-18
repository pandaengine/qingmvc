<?php
namespace qing\com;
/**
 * - 普通的应用组件的基类
 * - 不包含行为/事件功能
 * - 组件基类
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Component implements ComponentInterface{
	/**
	 * 当前组件名称/Container必须
	 *
	 * @var string
	 */
	public $comName;
	/**
	 *
	 * @param string $comName
	 * @return $this
	 */
	public function comName($comName){
		$this->comName=$comName;
		return $this;
	}
	/**
	 * @see \qing\com\ComponentInterface::initComponent()
	 */
	public function initComponent(){}
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
		throw new \Exception(L()->class_property_notfound.':'.get_class($this).'->'.$name );
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
}
?>
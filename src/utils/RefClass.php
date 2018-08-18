<?php
namespace qing\utils;
/**
 * 扩展函数库
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class RefClass{
	/**
	 * 访问私有成员方法
	 * 
	 * @param Object $object
	 * @param string $method
	 */
	public static function invoke($object,$method){
		$refMethod=new \ReflectionMethod($object,$method);
		//设置方法是否可以访问，例如通过设置可以访问能够执行私有方法和保护方法
		$refMethod->setAccessible(true);
		return $refMethod->invoke($object);
	}
	/**
	 * 获取类的父类的父类链
	 * C3->C2->C1
	 *
	 * @param string $class
	 */
	public static function getParentClasses($class){
		$refClass=new \ReflectionClass($class);
		$parents=[];
		do{
			/*@var $parent \ReflectionClass */
			$parent=$refClass->getParentClass();
			if($parent){
				$parents[]=$parent->getName();
				$refClass =$parent;
			}
		}while($parent);
		return $parents;
	}
}
?>
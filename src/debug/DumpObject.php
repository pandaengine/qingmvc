<?php 
namespace qing\debug;
use qing\utils\ObjectDump;
/**
 * 打印对象
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class DumpObject{
	/**
	 * 执行打印
	 * 
	 * @param mixed $object
	 */
	public static function dump($object){
		//对象反射
		$refObject  =new \ReflectionObject($object);
		$methods	=$this->getMethods($refObject);
		$properties	=$this->getProperties($refObject,$object);
		dump('---[成员方法]---');
		dump($methods);
		dump('---[成员属性]---');
		dump($properties);
	}
	/**
	 * 成员属性
	 *
	 * @param \ReflectionObject $refObject
	 * @param mixed $object
	 */
	protected static function getProperties(\ReflectionObject $refObject,$object){
		$list      =$refObject->getProperties();
		$properties=array();
		foreach($list as $refProperty){
			/*@var $refProperty \ReflectionProperty */
			$propName=$refProperty->getName();
			if(!$refProperty->isPublic()){
				//非public|设置为可访问
				$refProperty->setAccessible(true);
			}
			$class	 =$refProperty->class;
			$value	 =$refProperty->getValue($object);
			if(is_array($value)){
			    $value=arrayPretty($value);
			}else{
				$value=ObjectDump::toString($value);
			}
			$properties[$propName.'|'.$class]=$value;
			 
		}
		return $properties;
	}
	/**
	 * 成员方法
	 *
	 * @param \ReflectionObject $refObject
	 */
	protected static function getMethods(\ReflectionObject $refObject){
		$list   =$refObject->getMethods();
		$methods=array();
		foreach($list as $refMethod){
			/*@var $refMethod \ReflectionMethod */
			$methodName=$refMethod->getName();
			$class	   =$refMethod->class;
			//方法参数
			$parameters=$this->getParameters($refMethod);
			$methods[] ="{$class}->{$methodName}(".implode(',',$parameters).")";
		}
		return $methods;
	}
	/**
	 * 方法的参数和默认值
	 * 
	 * @param \ReflectionMethod $refMethod
	 * @return array
	 */
	protected static function getParameters(\ReflectionMethod $refMethod){
		$parameters =array();
		foreach($refMethod->getParameters() as $i=>$param){
			/* @var $param \ReflectionParameter */
			//参数的名字
			$paramName=$param->getName();
			//参数对应的反射类|参数约束类类型
			$constraintClass='';
			$parameterClass=$param->getClass();
			if(is_object($parameterClass)){
				//参数约束类名
				$constraintClass=$parameterClass->getName();
				$constraintClass.=' ';
			}
			if($param->isDefaultValueAvailable()){
				$parameters[]=$constraintClass.'$'.$paramName.'='.ObjectDump::toString($param->getDefaultValue());
			}else{
				$parameters[]=$constraintClass.'$'.$paramName;
			}
		}
		return $parameters;
	}
}
?>
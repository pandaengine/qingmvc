<?php
namespace qing\adapter;
use qing\facades\Request;
use qing\exceptions\http\NotFoundActionParameterException;
/**
 * Api处理器适配器
 * - 支持解析操作参数: 支持$_GET/$_POST/默认值
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ApiAdapter extends ControllerAdapter{
	/**
	 * 执行指定操作
	 *
	 * @param \qing\controller\Controller $ctrl
	 * @param string $ctrlName
	 * @param string $actionName 操作名称
	 * @return mixed
	 */
	protected function runAction($ctrl,$ctrlName,$actionName){
		$actionParams=$this->getActionDependencies();
		return $ctrl->_runAction($ctrlName,$actionName,$actionParams);
	}
	/**
	 * 注入操作函数参数
	 * index($id,\main\models\Sites $mSites,$name='')
	 * 
	 * - 参数：/$_GET/$_POST
	 * - 默认参数: $name=''
	 * - 类型声明约束: 解析依赖\main\models\Sites $mSites
	 * 
	 * 非默认参数
	 * $refMethod->getNumberOfRequiredParameters()
	 * 
	 * @return array
	 */
	protected function getActionDependencies(){
		$refMethod=$this->__refMethod;
		//没有参数
		if($refMethod->getNumberOfParameters()==0){
			return [];
		}
		$params=[];
		foreach($refMethod->getParameters() as $parameter){
			/* @var $parameter \ReflectionParameter */
			$params[]=$this->getDependency($parameter);
		}
		return $params;
	}
	/**
	 * # 参数来源，分请求方式
	 * 
	 * get: $_GET
	 * post: $_POST
	 * 
	 * @param \ReflectionParameter $parameter
	 * @return mixed
	 */
	protected function getDependency(\ReflectionParameter $parameter){
		if($parameter->getClass()){
			//#类名或接口/类型声明
			return $this->getDependencyByClass($parameter->getClass()->getName());
		}
		//普通参数
		$value=Request::input($parameter->name);
		if($value!==null){
			//#用户输入存在/格式化数据
			//php7,支持标量类型声明int/string/float/bool/array/declare(strict_types=1);
			$php7=version_compare(PHP_VERSION, '7.0.0')>0;
			if($php7 && $parameter->hasType()){
				//有类型声明
				$value=$this->formatData($value,$parameter);
			}
			return $value;
		}elseif($parameter->isDefaultValueAvailable()){
			//#默认值存在
			return $parameter->getDefaultValue();
		}else{
			//#参数没有输入也没有默认值
			throw new NotFoundActionParameterException(
					$parameter->getDeclaringClass()->getName().'::'.
					$parameter->getDeclaringFunction()->getName().'::'.
					'$'.$parameter->name);
		}
	}
	/**
	 * 格式化用户输入数据
	 * php7才支持
	 * 
	 * //内置类型/int/string/array
	 * $parameter->getType()->isBuiltin()
	 * 
	 * @param string $data
	 * @param \ReflectionParameter $parameter
	 */
	protected function formatData($data,\ReflectionParameter $parameter){
		//#有类型声明/int/float/string/bool/array
		$type=(string)$parameter->getType();
		switch($type){
			case 'int':		$data=(int)$data;break;
			case 'float':	$data=(float)$data;break;
			case 'bool':	$data=(bool)$data;break;
			case 'array':	$data=(array)$data;break;
		}
		return $data;
	}
	/**
	 * @param string $className
	 */
	protected function getDependencyByClass($className){
		$module=mod(AUTO_MODULE);
		$dic=$module->getContainer();
		$obj=null;
		if($dic->has($className)){
			//#从容器中取得实例|已经绑定到容器
			$obj=$dic->get($className);
		}elseif(class_exists($className)){
			//#简单实例化/接口或抽象类不能new
			$obj=new $className();
		}
		return $obj;
	}
}
?>
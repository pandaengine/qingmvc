<?php
namespace qing\container;
use qing\utils\Instance;
/**
 * 高级容器
 * 注入属性依赖更多样化
 * 
 * @deprecated 懒加载使用门面系统替代
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class AdvContainer extends Container{
	/**
	 * 懒加载
	 * 包装成一个匿名函数注入，要使用真正的实例，需要从匿名函数中获取
	 * call_user_func($di)->call();
	 * 
	 * @var string
	 */
	const LAZY='lazy';
	/**
	 * 引用
	 * - 只 配合lazy使用，其他使用字符串，或者使用闭包函数模拟
	 * ['ref'=>'id','lazy'=>true]
	 *
	 * @deprecated 弃用2018.06.11，使用字符串
	 * @var string
	 */
	const REF='ref';
	/**
	 * 解析属性依赖
	 *
	 * @param array $dis
	 * @return array
	 */
	public function setDis($instance,array $dis){
		foreach($dis as $diName=>$diValue){
			//字符串/数组/闭包/懒加载等
			$instance->$diName=$this->getDi($diValue);
		}
	}
	/**
	 * 解析依赖属性
	 * 解析注入的参数或属性
	 * 尝试解析依赖为组件
	 * 
	 * [
	 * '\main\controller\Index' =>
	 * [
	 * 	'class' => 'main\controller\Index',
	 * 	'mCat'  => ['class' => '\main\model\Cat','lazy'=>true],//懒加载
	 *  'mSetting' => ['ref' => 'mSetting'],//引用
	 *  'mSetting2' => 'mSetting',//引用
	 *  'mNote' => '\main\model\Note',
	 *  'mNote2' => function(){ return new ClassC();},
	 * ],
	 * 'mSetting'=>['class' => '\main\model\Setting']
	 * ];
	 * 
	 * - 依赖是引用：从容器中获取
	 * - 依赖是类定义：直接创建
	 * 
	 * - lazy:
	 * - class:
	 * - ref:
	 * 
	 * @param mixed $diValue
	 */
	protected function getDi($diValue){
		//#字符串|则认为是引用
		if(is_string($diValue)){
			return $this->get($diValue);
		}
		//#数组
		if(is_array($diValue)){
			//#是否是懒加载
			if(isset($diValue[self::LAZY])){
				unset($diValue[self::LAZY]);
				//#懒加载|返回闭包函数
				/*@var $closure \Closure */
				$closure=function()use($diValue){
					if(isset($diValue[self::REF])){
						//#引用
						return $this->get($diValue[self::REF]);
					}else{
						//#直接创建
						return Instance::create($diValue,true);
					}
				};
				//注入闭包
				return $closure;
			}
		}
		//创建实例
		return Instance::create($diValue,true);
	}
}
?>
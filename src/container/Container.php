<?php
namespace qing\container;
use qing\utils\Instance;
use qing\exceptions\NotSupportException;
/**
 * 实例容器
 * - 跟Component不同的是，组件注入常规属性(string/array/number)
 * - 容器则只注入依赖的实例
 *
 * 简单容器
 * - 属性依赖全部从容器中获取，属性依赖只支持字符串，都是容器id
 * - 容器值可以是
 * 	- 字符串类名
 *  - 闭包
 *  - 数组
 *  
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Container extends ServiceLocator{
	/**
	 * 容器实例分类
	 * 
	 * - 字符串 ['M'=>'\main\model\%s','C'=>'\main\controller\%s']
	 * - 闭包函数 ['M'=>function($id){ return '\main\model\\'.$id; }]
	 * - M:User/C:Index
	 * 
	 * @var array
	 */
	protected $_cats=[];
	/**
	 * 注入信息
	 *
	 * @param array/string $maps
	 * @return array
	 */
	public function setMaps($maps){
		if(!is_array($maps) && is_file((string)$maps)){
			//#字符串路径
			$maps=include $maps;
		}
		$this->setServices((array)$maps);
	}
	/**
	 *
	 * @param array $cats
	 * @return array
	 */
	public function setCats(array $cats){
		$this->_cats=$cats;
	}
	/**
	 * 实例创建器
	 *
	 * @param string $id
	 */
	public function byCat($id){
		$exp=explode(':',$id);
		if(count($exp)!=2){
			return false;
		}
		$cat=$exp[0];
		$rid=$exp[1];//real id
		if(!isset($this->_cats[$cat])){
			return false;
		}
		$srv=$this->_cats[$cat];
		if(is_string($srv)){
			//#字符串
			$rid=ucfirst($rid);
			return vsprintf($srv,[$rid]);
		}elseif($srv instanceof \Closure){
			//#闭包函数
			return call_user_func($srv,$rid);
		}else{
			throw new NotSupportException('container cat : '.$id);
		}
	}
	/**
	 * 获取服务
	 *
	 * @param string $id 服务标识ID
	 * @return mixed
	 */
	public function get($id){
		if(isset($this->_instances[$id])){
			//#服务已经被装载
			return $this->_instances[$id];
		}
		//找不到组件
		if(!isset($this->_services[$id])){
			//#从实例分类中查找
			$service=$this->byCat($id);
			if(!$service){
				throw new exceptions\NotfoundItem($id);
			}
		}else{
			$service=$this->_services[$id];
		}
		return $this->_instances[$id]=$this->create($service,$id);
	}
	/**
	 * 创建服务
	 *
	 * @param string $service 服务配置
	 * @return mixed
	 */
	public function create($service,$id=''){
		//创建实例
		$instance=Instance::create($service,false);
		//
		if($service && is_array($service)){
			//注入依赖属性
			foreach($service as $diName=>$diValue){
				//字符串
				$instance->$diName=$this->getDependency($diValue);
				//如果不是字符串，且不在容器中则作为普通属性注入?暂不实现，简单才是硬道理
				//如果是类名，又不存在容器中，直接创建?
			}
		}
		return $instance;
	}
	/**
	 * 解析属性依赖
	 * - lite简单模式 ，只支持字符串，只支持从容器中获取
	 * - 和 ServiceLocator最大不同体现在这里，ServiceLocator属性是各种标量或数组等数据，容器属性则是依赖实例id
	 *
	 * @param array $dis
	 * @return array
	 */
	public function getDependency($prop){
		if(is_string($prop)){
			//#字符串
			return $this->get($prop);
		}else{
			//#其他，递归处理
			//return Instance::create($prop,false);
			return $this->create($prop);
		}
	}
}
?>
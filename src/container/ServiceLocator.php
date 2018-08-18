<?php
namespace qing\container;
use qing\utils\Instance;
use qing\com\Component;
/**
 * 服务定位器
 * 
 * - 单例模式|每次获取的都是同一个实例
 * - 应用主线的服务定位
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ServiceLocator extends Component implements ServiceLocatorInterface{
	/**
	 * 已加载服务实例列表
	 *
	 * @var array
	 */
	protected $_instances=[];
	/**
	 * 服务配置列表
	 * 
	 * @var array
	*/
	protected $_services=[];
	/**
	 * 设置服务配置
	 * 如果服务已实例化，需要可以先remove
	 * 
	 * @name bind
	 * @param string  $id 	         服务ID/log/db
	 * @param mixed   $service 服务信息
	 * @return void
	 */
	public function set($id,$service){
		if(is_array($service) && isset($this->_services[$id])){
			//合并
			$this->_services[$id]=array_merge($this->_services[$id],$service);
		}else{
			//不合并
			$this->_services[$id]=$service;
		}
		return true;
	}
	/**
	 * 设置多个应用服务，配置文件里的Services会通过该方法注入
	 *
	 * @param array $services 多个服务的配置
	 */
	public function sets(array $services){
		foreach($services as $id=>$service){
			$this->set($id,$service);
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
		$service=$this->_services[$id];
		//找不到组件
		if(!$service){
			throw new exceptions\NotfoundItem($id);
		}
		return $this->_instances[$id]=$this->create($service,$id);
	}
	/**
	 * 创建服务
	 *
	 * @param string $service 服务配置
	 * @param string $id
	 * @return mixed
	 */
	public function create($service,$id=''){
		//创建实例
		return Instance::create($service,true);
	}
	/**
	 * 已经加载的实例
	 *
	 * @param string $id 服务ID
	 * @return boolean
	 */
	public function hasInstance($id){
		return isset($this->_instances[$id]);
	}
	/**
	 * 服务是否存在
	 *
	 * @name exists
	 * @param string $id 服务ID
	 * @return boolean
	 */
	public function has($id){
		return isset($this->_services[$id]) || isset($this->_instances[$id]);
	}
	/**
	 * 移除已加载服务
	 *
	 * @param string  $id 服务ID标识
	 * @return boolean
	 */
	public function removeInstance($id){
		unset($this->_instances[$id]);
		return true;
	}
	/**
	 * 移除服务
	 *
	 * @param string  $id 服务ID标识
	 * @return boolean
	 */
	public function remove($id){
		unset($this->_instances[$id]);
		unset($this->_services[$id]);
		return true;
	}
	/**
	 * 获取服务配置
	 *
	 * @param string  $id 服务ID标识
	 * @return array
	 */
	public function getService($id){
		return $this->_services[$id];
	}
	/**
	 * 覆盖所以配置
	 * 
	 * @param array $srvs
	 */
	public function setServices(array $srvs){
		$this->_services=$srvs;
	}
	/**
	 * 获取服务配置
	 *
	 * @return array
	 */
	public function getServices(){
		return $this->_services;
	}
	/**
	 * 测试函数
	 * 
	 * @deprecated
	 */
	public function _printServices(){
		dump($this->_instances);
		dump($this->_services);
	}
}
?>
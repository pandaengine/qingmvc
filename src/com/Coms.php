<?php
namespace qing\com;
use qing\container\ServiceLocator;
use qing\utils\Instance;
use qing\exceptions\NotmatchClassException;
use qing\exceptions\NotfoundClassException;
/**
 * 组件管理器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Coms extends ServiceLocator{
	/**
	 * 创建服务
	 *
	 * @param string $service 服务配置
	 * @return mixed
	 */
	public function create($service,$id=''){
		if(is_array($service) && isset($service['creator'])){
			//#根据提供器创建服务
			$instance=$this->createByCreator($service);
		}else{
			//#根据配置创建服务
			$instance=Instance::create($service,true);
		}
		//#先关联应用再注入属性
		//#不一定必须实现ComponentInterface，比如smarty.creator
		if($instance instanceof ComponentInterface){
			//#关联应用和初始化组件
			$instance->comName($id);
			//#先注入属性再初始化
			$instance->initComponent();
		}
		return $instance;
	}
	/**
	 * 取得服务提供器
	 *
	 * @param array $service
	 * @see \qing\container\ServiceCreator
	 */
	protected function createByCreator(array $service){
		$creator=$service['creator'];
		unset($service['creator']);
		if(!class_exists($creator)){
			throw new NotfoundClassException($creator);
		}
		$_creator=new $creator();
		if(!($_creator instanceof ComCreatorInterface)){
			throw new NotmatchClassException(get_class($_creator),ComCreatorInterface::class);
		}
		//创建组件
		$instance=$_creator->create();
		//#注入组件属性|引用传递
		Instance::setProps($instance,$service);
		//设置组件
		$_creator->setup($instance);
		return $instance;
	}
}
?>
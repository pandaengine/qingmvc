<?php
namespace qing\app\traits;
use qing\interceptor\InterceptorInterface;
use qing\utils\Instance;
/**
 * 应用拦截器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
trait InterceptorTrait{
	/**
	 * 拦截器链
	 * 
	 * @name $itctIds
	 * @var array
	 */
	protected $_interceptors=[];
	/**
	 * 拦截器链|组件名称
	 *
	 * @name $itctIds
	 * @var array
	 */
	protected $_rinterceptors=[];
	/**
	 * @param array $itcts
	 */
	public function setInterceptors(array $itcts){
		$this->_interceptors=$itcts;
	}
	/**
	 * 格式化拦截器信息
	 * 把拦截器添加到组件
	 * 
	 * - 获取处理器拦截器
	 * - 前置处理为顺序
	 * - 后置处理为逆序
	 * - 完成处理为逆序
	 *
	 * 123456->654321
	 *
	 * @param array $list
	 */
	protected function formatInterceptors(array $itcts){
		$this->_interceptors=[];//清除
		foreach($itcts as $k=>$itct){
			if(!is_object($itct)){
				$itct=Instance::create($itct,true);
			}
			if(!$itct instanceof InterceptorInterface){
				throw new \qing\exceptions\NotmatchClassException(get_class($itct),InterceptorInterface::class);
			}
			$this->_interceptors[]=$itct;
		}
		//逆序
		if($this->_interceptors){
			$itcts=$this->_interceptors;
			//按键值逆序排序
			krsort($itcts);
			$this->_rinterceptors=$itcts;
		}
	}
	/**
	 * - 执行前置处理器
	 * - 前端控制器开始时
	 * - 初始化应用环境后未进行任何操作/包括路由
	 * 
	 * @return boolean
	 */
	protected function applyPreHandle(){
		if(!$this->_interceptors){ return true; }
		//格式化拦截器
		$this->formatInterceptors($this->_interceptors);
		/* @var $itct \qing\interceptor\InterceptorInterface */
		$itct=null;
		$res=true;
		foreach($this->_interceptors as $itct){
			$res=(bool)$itct->preHandle();
			if(!$res){
				//处理失败/false
				break;
			}
		}
		//销毁内存
		unset($this->_interceptors);
		return $res;
	}
	/**
	 * 执行后置处理器
	 * - 执行空函数问题
	 * - 总是比使用事件实现，调用的函数更少更快
	 * 
	 * @return boolean
	 */
	protected function applyPostHandle(){
		if(!$this->_rinterceptors){ return true; }
		/* @var $itct \qing\interceptor\InterceptorInterface */
		$itct=null;
		foreach($this->_rinterceptors as $itct){
			$itct->postHandle();
		}
		return true;
	}
	/**
	 * 执行处理完成后处理器
	 *
	 * @return boolean
	 */
	protected function applyAfterCompletion(){
		if(!$this->_rinterceptors){ return true; }
		/* @var $itct \qing\interceptor\InterceptorInterface */
		$itct=null;
		foreach($this->_rinterceptors as $itct){
			$itct->afterCompletion();
		}
		return true;
	}
}
?>
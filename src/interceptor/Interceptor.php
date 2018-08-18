<?php
namespace qing\interceptor;
use qing\com\Component;
/**
 * - 应用基本拦截器
 * - 处理器拦截器
 * - 应用级别/请求级别的拦截器
 * - 全局性的拦截器
 * - 类似servlet-filter
 * 
 * @abstract ?
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Interceptor extends Component implements InterceptorInterface{
	/**
	 * @see \qing\interceptor\InterceptorInterface::preHandle()
	 */
	public function preHandle(){
		return true;
	}
	/**
	 * @see \qing\interceptor\InterceptorInterface::postHandle()
	 */
	public function postHandle(){
		return true;
	}
	/**
	 * @see \qing\interceptor\InterceptorInterface::afterCompletion()
	 */
	public function afterCompletion(){
		return true;
	}
}
?>
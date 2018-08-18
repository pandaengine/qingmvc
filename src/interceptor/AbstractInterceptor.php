<?php
namespace qing\interceptor;
use qing\com\Component;
/**
 * 抽象拦截器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
abstract class AbstractInterceptor extends Component implements InterceptorInterface{
	/**
	 * @see \qing\interceptor\InterceptorInterface::preHandle()
	 */
	abstract public function preHandle();
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
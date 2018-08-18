<?php
namespace qing\session;
use qing\interceptor\Interceptor;
use qing\facades\Session;
/**
 * sessin自动开启和设置拦截器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SessionInterceptor extends Interceptor{
	/**
	 * @see \qing\interceptor\Interceptor::preHandle()
	 */
	public function preHandle(){
		//自动开启session
		Session::start();
		return true;
	}
}
?>
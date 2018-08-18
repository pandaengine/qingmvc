<?php
namespace qing\config;
use qing\interceptor\Interceptor;
/**
 * 配置快速访问提示类生成器
 * 拦截器
 * 
 * @name config_tip
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ConfigTipInterceptor extends Interceptor{
	/**
	 * @see \qing\interceptor\Interceptor::preHandle()
	 */
	public function preHandle(){
		return true;
		
		dump(__METHOD__);
		$config=coms()->get('config');
		dump($config);
		
// 		dump(C::$appName2);
		dump(C::appName());
		dump(config());
	}
}
?>
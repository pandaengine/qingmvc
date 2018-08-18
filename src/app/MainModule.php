<?php 
namespace qing\app;
use qing\Qing;
/**
 * 主模块
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MainModule extends Module{
	/**
	 * 模块初始化
	 * 
	 * @see \qing\app\Module::init()
	 */
	public function initModule(){
		//#主模块路径是应用的基础路径
		$app=Qing::$app;
		//主模块配置使用应用配置，不要单独设置，会产生冲突
		$this->namespace=='' && $this->namespace=$app->namespace;
		$this->basePath==''  && $this->basePath =$app->basePath;
	}
	/**
	 * 执行主模块
	 * - 主模块执行之前
	 * - 应用执行之前
	 * - aop|拦截应用之前
	 * 
	 * @param \qing\router\RouteBag $routeBag
	 * @return boolean
	 */
	public function beforeMainModule($routeBag){
		return true;
	}
}
?>
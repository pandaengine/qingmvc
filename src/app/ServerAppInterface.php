<?php
namespace qing\app;
/**
 * 应用接口
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface ServerAppInterface{
	/**
	 * 执行服务器应用
	 *
	 * @param string $ctrl		执行控制器
	 * @param string $action	执行操作
	 * @param array  $params
	 * @param string $module	执行模块
	 */
	public function runAction($ctrl,$action,array $params=[],$module=MAIN_MODULE);
	/**
	 * 创建控制器|可以更改容器
	 *
	 * @param string $ctrlName
	 * @param string $module
	 * @return \qing\controller\Controller
	 */
	public function getController($ctrlName,$module=MAIN_MODULE);
}
?>
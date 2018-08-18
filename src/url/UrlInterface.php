<?php
namespace qing\url;
/**
 * URL生成器接口
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface UrlInterface{
	/**
	 *
	 * @param string $module 	模块
	 * @param string $ctrl 		控制器
	 * @param string $action 	操作
	 * @param array  $params 	附加参数
	 * @return string
	 */
	public function create($module,$ctrl,$action,array $params=[]);
}
?>
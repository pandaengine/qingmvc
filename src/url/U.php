<?php
namespace qing\url;
use qing\facades\UrlManager;
/**
 * url组件
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class U{
	/**
	 * url创建器
	 * 创建url|控制器和操作不填写则自动获取
	 *
	 * - 模块为null时|剔除模块也不自动获取模块
	 * - 模块为空不为null|自动
	 *
	 * @see \qing\url\UrlManager
	 * @param string $module
	 * @param string $ctrl
	 * @param string $action
	 * @param array  $params
	 * @return string
	 */
	static public function url_OFF($module,$ctrl='',$action='',array $params=[]){
		if(!$module){
			if($module!==null && MODULE_NAME!=MAIN_MODULE){
				//自动获取
				$module=MODULE_NAME;
			}
			//#没有指定模块时才获取默认
			if($ctrl=='' && $action==''){
				//#空则自动获取
				$ctrl  =CTRL_NAME;
				$action=ACTION_NAME;
			}elseif($ctrl==''){
				//#空则自动获取
				$ctrl=CTRL_NAME;
			}
		}
		return UrlManager::create($module,$ctrl,$action,$params);
	}
	/**
	 * url短链接
	 *
	 * @param string $alias
	 * @return string
	 */
	static public function short($alias){
		/*@var $short \qing\url\Short */
		$short=com('url_short');
		return $short->get($alias);
	}
}
?>
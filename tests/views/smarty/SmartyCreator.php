<?php
namespace qtests\views\smarty;
use qing\com\ComCreator;
/**
 * 组件创建类
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SmartyCreator extends ComCreator{
	/**
	 * @see \qing\com\ComCreator::create()
	 */
	public function create(){
		$smarty=new \Smarty();
		$smarty->force_compile  = false;
		$smarty->debugging 		= false;
		$smarty->caching 		= true;
		$smarty->cache_lifetime = 120;
		//
		$runtimePath=APP_RUNTIME.DS.'~smarty02';
		$smarty->setTemplateDir(__DIR__.'/templates');
		$smarty->setConfigDir(__DIR__.'/configs');
		$smarty->setCacheDir($runtimePath.'/cache');
		$smarty->setCompileDir($runtimePath.'/templates_c');
		//
		return $smarty;
	}
}
?>
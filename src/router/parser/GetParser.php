<?php
namespace qing\router\parser;
use qing\router\ParserInterface;
use qing\router\RouteBag;
/**
 * Get参数解析器
 * 
 * index.php?c=Index&a=login&id=1&name=xiaowang
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class GetParser implements ParserInterface{
	/**
	 * @see \qing\router\ParserInterface::match()
	 */
	public function parse(){
 		$module=(string)@$_GET[RKEY_MODULE];
		$ctrl  =(string)@$_GET[RKEY_CTRL];
		$action=(string)@$_GET[RKEY_ACTION];
		//
		if(!$module && !$ctrl && !$action){
			//使用默认路由
			return ParserInterface::INDEX;
		}
		if(!$module){
			$module=DEF_MODULE;
		}
		if(!$ctrl){
			$ctrl=DEF_CTRL;
		}
		if(!$action){
			$action=DEF_ACTION;
		}
		return new RouteBag($module,$ctrl,$action);
	}
}
?>
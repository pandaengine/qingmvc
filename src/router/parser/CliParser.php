<?php
namespace qing\router\parser;
use qing\router\ParserInterface;
use qing\router\RouteBag;
/**
 * 命令行参数解析器
 * 
 * php -f cli.php "m=main&c=index&a=index"
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CliParser implements ParserInterface{
	/**
	 * @see \qing\router\ParserInterface::match()
	 */
	public function parse(){
		global $argc,$argv;
		if($argc>1){
			//路由解析
			parse_str((string)$argv[1],$route);
			$module=(string)@$route[RKEY_MODULE];
			$ctrl  =(string)@$route[RKEY_CTRL];
			$action=(string)@$route[RKEY_ACTION];
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
		}else{
			//使用默认路由
			return ParserInterface::INDEX;
		}
	}
}
?>
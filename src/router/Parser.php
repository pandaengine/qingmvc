<?php
namespace qing\router;
/**
 * 路由解析器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
abstract class Parser implements ParserInterface{
	/**
	 * @name matchRoute
	 */
	abstract public function parse();
}
?>
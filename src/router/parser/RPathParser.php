<?php
namespace qing\router\parser;
/**
 * R参数解析器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class RPathParser extends PathInfoParser{
	/**
	 * 路由参数的键值
	 * 
	 * @var string
	 */
	public $keyRoute="r";
	/**
	 *
	 * @return string
	 */
	protected function getRoute(){
		return isset($_GET[$this->keyRoute])?$_GET[$this->keyRoute]:'';
	}
}
?>
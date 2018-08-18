<?php
namespace qing\router;
/**
 * 路由解析器接口
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface ParserInterface{
	//找不到路由
	const NOT_FOUND = 0;
	//找到路由
	const FOUND 	= 1;
	//解析结束，不再继续下一个解析器
	const END		= -1;
	/**
	 * 使用默认路由
	 * path:pathinfo为空时
	 * get: m c a 均为空时
	 * 
	 * 不考虑path和get混用的情况
	 * 
	 * @name INDEX DEF
	 * @var number
	 */
	const INDEX 	= 2;
	/**
	 * 路由解析
	 * 路由匹配
	 */
	public function parse();
}
?>
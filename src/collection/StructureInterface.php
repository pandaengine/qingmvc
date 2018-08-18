<?php
namespace qing\collection;
/**
 * 数据结构接口
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface StructureInterface{
	/**
	 * 入栈/入列
	 * 
	 * @param string $item
	 */
	public function push($item);
	/**
	 * 出栈/出列
	 * 
	 * @param string $item
	 */
	public function pop($item);
	/**
	 * 清除
	 * 
	 * @param string $item
	 */
	public function clear();
}
?>
<?php
namespace qing\collection;
/**
 * 栈|先进后出！
 * 
 * - 先进后出！
 * - 只操作头部|不操作尾部
 * - 从头部压栈|从头部出栈
 * 
 * array_unshift 从数组头部追加元素 | Prepend one or more elements to the beginning of an array
 * array_shift 从数组头部移除返回元素 |Shift an element off the beginning of array
 * 
 * ---
 * ↓入栈   ↑出栈
 * ---  --- 栈顶
 * ---  ---
 * -栈- -栈-
 * ---  ---
 * ---  --- 栈尾
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Stack extends Structure{
	/**
	 * 入栈|追加到头部
	 * 栈|先入后出！
	 * 
	 * @param mixed $item
	 * @return $this
	 */
	public function push($item){
		//追加到头部
		array_unshift($this->datas,$item);
		return $this;
	}
	/**
	 * 出栈 |从头部移除并返回
	 * 
	 * @param mixed $item
	 * @return mixed
	 */
	public function pop($item){
		return array_shift($this->datas);
	}
}
?>
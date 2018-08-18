<?php
namespace qing\collection;
/**
 * 队列|先进先出！
 * 
 * #尾部|操作尾部
 * array_push |从数组尾部追加数元素| Push one or more elements onto the end of array
 * array_pop |从数组尾部移除数元素 | Pop the element off the end of array
 * 
 * #头部|操作头部
 * array_unshift 从数组头部追加元素 | Prepend one or more elements to the beginning of an array
 * array_shift 从数组头部移除返回元素 |Shift an element off the beginning of array
 * 
 * --------------------------------------------------------
 * 
 * 出队    队头		队尾	入队
 * ←←← ||||||||||| ←←←
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Queue extends Structure{
	/**
	 * 入列|追加到数组尾部|追加到队列尾部
	 *
	 * @param mixed $item
	 * @return $this
	 */
	public function push($item){
		array_push($this->datas,$item);
		return $this;
	}
	/**
	 * 出列 |从头部移除并返回
	 *
	 * @param mixed $item
	 * @return mixed
	 */
	public function pop($item){
		return array_shift($this->datas);
	}
}
?>
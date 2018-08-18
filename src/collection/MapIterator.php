<?php
namespace qing\collection;
/**
 * Map迭代器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MapIterator implements \Iterator{
	/**
	 * @var array 迭代数据
	 */
	private $_data;
	/**
	 * @var array 集合键值
	 */
	private $_keys;
	/**
	 * @var mixed 当前键值
	 */
	private $_key;
	/**
	 * @param array 
	 */
	public function __construct(&$data){
		$this->_data=&$data;
		$this->_keys=array_keys($data);
		$this->_key =reset($this->_keys);
	}
	/**
	 * 倒置数组内部指针,倒置数组键值顺序
	 * 返回到迭代器的第一个元素,并重置指针
	 * reset() 函数把数组的内部指针指向第一个元素，并返回这个元素的值。
	 * 
	 * @see Iterator::rewind()
	 */
	public function rewind(){
		$this->_key=reset($this->_keys);
	}
	/**
	 * 返回当前元素的键
	 * 
	 * @see Iterator::key()
	 */
	public function key(){
		return $this->_key;
	}
	/**
	 * 返回当前元素
	 * 
	 * @see Iterator::current()
	 */
	public function current(){
		return $this->_data[$this->_key];
	}
	/**
	 * 移动当前位置到下一个元素。
	 * 
	 * @see Iterator::next()
	 */
	public function next(){
		$this->_key=next($this->_keys);
	}
	/**
	 * 检查当前位置是否有效
	 * 
	 * @see Iterator::valid()
	 */
	public function valid(){
		return $this->_key!==false;
	}
}
?>
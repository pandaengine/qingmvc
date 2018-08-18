<?php
namespace qing\arr;
/**
 * ArrayAccess：提供像访问数组一样访问对象的能力的接口
 * 
 * @see http://php.net/manual/zh/class.arrayaccess.php
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ArrayAccess implements \ArrayAccess{
	/**
	 * @var array
	 */	
	protected $datas=[];
	/**
	 * 获取一个偏移位置的值
	 * 
	 * @see ArrayAccess::offsetGet()
	 */
	public function offsetGet($offset){
		return isset($this->datas[$offset])?$this->datas[$offset]:null;
	}
	/**
	 * 检查一个偏移位置是否存在
	 *
	 * @see ArrayAccess::offsetExists()
	 */
	public function offsetExists($offset){
		return isset($this->datas[$offset]);
	}
	/**
	 * 设置一个偏移位置的值
	 *
	 * @see ArrayAccess::offsetSet()
	 */
	public function offsetSet($offset,$value){
		if(is_null($offset)){
			$this->datas[]=$value;
		}else{
			$this->datas[$offset]=$value;
		}
	}
	/**
	 * 复位一个偏移位置的值
	 *
	 * @see ArrayAccess::offsetUnset()
	 */
	public function offsetUnset($offset){
		unset($this->datas[$offset]);
	}
}
?>
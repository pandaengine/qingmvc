<?php
namespace qing\collection;
/**
 * 数据结构
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
abstract class Structure implements StructureInterface{
	/**
	 * 数据
	 *
	 * @var array
	 */
	protected $datas=[];
	/**
	 * @param array $datas
	 */
	public function __construct($datas){
		$this->datas=$datas;
	}
	/**
	 * 入栈/入列
	 * 
	 * @param mixed $item
	 * @return $this
	 */
	abstract public function push($item);
	/**
	 * 出栈/出列
	 * 
	 * @param mixed $item
	 * @return mixed
	 */
	abstract public function pop($item);
	/**
	 * 清除
	 */
	public function clear(){
		$this->datas=[];
	}
}
?>
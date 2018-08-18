<?php
namespace qing\event;
/**
 * 数据数据包
 * Event事件属性对象,在各个事件处理器中更改event中的参数即可
 * 携带各个处理器之间交流的数据
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class EventBag implements EventBagInterface{
	/**
	 * 事件点名称
	 * 
	 * @var string
	 */
	public $name;
	/**
	 * 事件触发点目标
	 * 
	 * @name qt sender
	 * @var string|object
	 */
	public $target;
	/**
	 * - 事件的原始参数，参数的一个拷贝
	 * - 一般情况下不更改该参数；
	 * - source params
	 * - original data
	 * 
	 * 取得属性
	 * - 获取原始的参数
	 * - 在非第一个处理器的情况下，可以取得原始数据处理
	 * 
	 * @var $srcParams $srcData
	 * @var mixed/array
	 */
	public $oridata;
	/**
	 * - 传入事件的参数
	 * - 多个事件处理器的时候，该参数可能是被上一个处理器更改过的
	 * - 经过事件处理器链处理的数据
	 * - 事件点携带的数据
	 * 
	 * @name $params $data
	 * @var mixed/array
	 */
	public $data;
	/**
	 * - 事件结束，不再执行下面的监听器
	 * - 是否中断，事件可以中断
	 * - 最后一个处理器，不再执行下面的事件处理器
	 * - 是否是最后一个处理器
	 * 
	 * @name stopPropagation | jquery事件停止传播停止冒泡
	 * @see final|isBreak
	 * @var bool
	 */
	public $finish=false;
	/**
	 * 构造函数
	 * 
	 * @param mixed $data
	 * @param mixed $target
	 */
	public function __construct($data=null,$target=null){
		$this->oridata=$data;
		$this->data   =$data;
		$this->target =$target;
	}
	/**
	 * @param string $name
	 * @return $this
	 */
	public function name($name){
		$this->name=$name;
		return $this;
	}
	/**
	 * @param mixed $target
	 * @return $this
	 */
	public function target($target){
		$this->target=$target;
		return $this;
	}
	/**
	 * 
	 * @param mixed $oridata
	 * @return $this
	 */
	public function oridata($oridata){
		$this->oridata=$oridata;
		return $this;
	}
	/**
	 * 
	 * @param mixed $data
	 * @return $this
	 */
	public function data($data){
		$this->data=$data;
		return $this;
	}
	/**
	 * @param boolean $finish
	 * @return $this
	 */
	public function finish($finish){
		$this->finish=(bool)$finish;
		return $this;
	}
}
?>
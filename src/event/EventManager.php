<?php 
namespace qing\event;
use qing\com\Component;
use qing\exceptions\UncallableException;
use qing\utils\ObjectDump;
/**
 * 事件管理器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class EventManager extends Component implements EventManagerInterface{
	/**
	 * 事件信息
	 * 绑定的监听器/处理器链表
	 * 原始的监听器链表|包含排序信息
	 * 
	 * @var array
	 */
	protected $events=[];
	/**
	 * 监听的事件点
	 * 事件钩子
	 * 
	 * @var array
	 */
	protected $hooks=[];
	/**
	 * 已排序事件钩子
	 *
	 * @var array
	 */
	protected $sorted=[];
	/**
	 * 初始化组件
	 * 
	 * @see \qing\com\Component::initComponent()
	 */
	public function initComponent(){
	}
	/**
	 * 根据优先级获取唯一id
	 * 用于排序
	 * 
	 * 注意：一个事件点绑定的监听器不能超过1000个，否则可能导致排序失效!
	 * 
	 * @param string $name
	 * @param number $priority
	 * @return number
	 */
	public function getId($name,$priority){
		//扩大1000
		$priority=1000*(int)$priority;
		if(isset($this->events[$name][$priority])){
			//id优先级已经存在
			//追加唯一后缀,加上尾巴
			$priority=$priority+count($this->events[$name]);
		}
		return $priority;
	}
	/**
	 * 是否绑定有监听器
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function has($name){
		return isset($this->events[$name]);
	}
	/**
	 * - 绑定一次性的处理器/监听器
	 * - 监听器执行一次后移除
	 *
	 * @see attach one once
	 * @param string 	$name 	            事件点
	 * @param callback  $listener   监听器
	 * @param number    $priority	监听器优先级
	 */
	public function once($name,$listener,$priority=10){
		//监听器信息包裹
		$bag=new ListenerBag($listener);
		$bag->once(true);
		$this->bind($name,$bag,$priority);
	}
	/**
	 * 绑定注册事件监听器/处理器
	 * 
	 * array 键值不能是float
	 * 一个事件处理器必须是有效的php回调。
	 * [处理器,调用优先级]
	 *
	 * @name bind on attach register
	 * @param string 	$name 	            事件点
	 * @param callback  $listener   监听器
	 * @param number    $priority	监听器优先级/int/float
	 */
	public function bind($name,$listener,$priority=10){
		$this->events[$name][$this->getId($name,$priority)]=$listener;
		//需要重新排序
		$this->unsort($name);
	}
	/**
	 * - 解绑某个事件点的所有监听器
	 * - 解绑某个事件点的某个监听器
	 * 
	 * @name  unbind detach unregister
	 * @param string $name	 	事件名称
	 * @param mixed  $listener 	监听器
	 */
	public function unbind($name,$listener=''){
		if(!isset($this->events[$name])){
			return;
		}
		if(!$listener){
			//解绑事件点的所有监听器
			unset($this->events[$name]);
			unset($this->sorted[$name]);
		}else{
			//解绑指定的某个监听器
			foreach($this->events[$name] as $k=>$lsn){
				//遍历监听器链，找到相等的监听器
				//监听器类型不同不可比较，否则抛出异常！php会尝试类型转换再比较
				//比如字符串和对象比较
				if($lsn===$listener){
					//类型必须一致，不会导致类型转换
					//[class,method]/"class::method"/[object,method]
					//string
					//object
					unset($this->events[$name][$k]);
				}
			}
		}
	}
	/**
	 * 触发/监听某个事件点
	 * 执行所有监听器
	 * 
	 * @name trigger listen emit fire
	 * @param string $name
	 * @param mixed  $data
	 * @return \qing\event\EventBag
	 */
	public function trigger($name,$data=null){
		$this->hooks[$name]=$name;
		//排序监听器
		$this->sort($name);
		//监听器链
		$listeners=$this->getListeners($name);
		if(!$listeners){ return $data; }
		//
		$isEventBag=$data instanceof EventBag;
		if($isEventBag){
			$data->name($name);
		}
		//#遍历监听器链表
		foreach($listeners as $id=>$listener){
			if($isEventBag && $data->finish){
				//最后一个监听器/跳出遍历
				break;
			}
			if($listener instanceof ListenerBag){
				//#ListenerBag包/监听器只执行一次/移除该监听器
				/*@var $listener ListenerBag */
				if($listener->once){
					unset($this->events[$name][$id]);
				}
				//取出真正的监听器
				$listener=$listener->listener;
			}
			//执行监听器
			$this->runListener($listener,$data);
		}
		return $data;
	}
	/**
	 * 执行监听器
	 * 
	 * 静态函数：[class,method]/"class::method"
	 * 对象成员函数：[object,method]
	 * 
	 * @param  mixed $listener
	 * @param  mixed $data
	 */
	public function runListener($listener,$data){
		if($listener instanceof \Closure){
			//#匿名函数/闭包/Closure/function(){}
			return call_user_func($listener,$data);
		}elseif(is_array($listener)){
			//#数组/静态函数[class,method]/[object,method]
			try{
				return call_user_func($listener,$data);
			}catch(\Exception $e){
				throw $e;
			}
		}else{
			throw new UncallableException(ObjectDump::toString($listener));
		}
	}
	/**
	 * 移除排序
	 * 
	 * - 绑定新监听器
	 *
	 * @param  string $name
	 * @return array
	 */
	public function unsort($name){
		if(isset($this->sorted[$name])){
			unset($this->sorted[$name]);
		}
	}
	/**
	 * 排序事件钩子的监听器链
	 *
	 * @param  string $name
	 * @return array
	 */
	public function sort($name){
		if(!isset($this->sorted[$name])){
			if(isset($this->events[$name])){
				//排序
				//SORT_STRING-单元被作为字符串来比较
				//SORT_NATURAL
				ksort($this->events[$name]);
			}
			$this->sorted[$name]=1;
		}
	}
	/**
	 * 获取某个事件的监听器链/处理器链
	 *
	 * @param  string $name
	 * @return array
	 */
	public function getListeners($name){
		if(isset($this->events[$name])){
			return $this->events[$name];
		}else{
			return [];
		}
	}
	/**
	 * 已经绑定处理器的事件点
	 * 
	 * @return array
	 */
	public function getEvents(){
		return array_keys($this->events);
	}
	/**
	 * 已经触发的事件点钩子
	 *
	 * @return array
	 */
	public function getHooks(){
		return $this->hooks;
	}
}
?>
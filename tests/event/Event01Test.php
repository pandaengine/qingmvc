<?php
namespace qtests\event;
use qtests\TestCase;
use qing\facades\Event;
use qing\event\EventBag;
use qing\event\ListenerBag;
//
class ListenerClass{
	/**
	 * 监听器12
	 * 成员函数
	 *
	 * @param \qing\event\EventBag $data
	 */
	public function listener12($data){
		$data->data.='>12';
	}
	/**
	 * 监听器10
	 * 静态函数
	 *
	 * @param \qing\event\EventBag $data
	 */
	public static function listener10($data){
		$data->data.='>10';
	}	
}
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Event01Test extends TestCase{
    /**
     * 在监听器中返回数据是没有意义的
     */
    public function test(){
    	/*@var $data \qing\event\EventBag */
    	//事件点名称/钩子名称
    	$hook='hook01';
    	Event::unbind($hook);
    	
    	$this->assertTrue(!Event::has($hook));
    	
    	//#绑定事件监听器
    	Event::bind($hook,[new ListenerClass(),'listener12'],12);
    	//优先级相同，先绑定优先级高
    	Event::bind($hook,[ListenerClass::class,'listener10'],10);
    	$func10_2=function($data){ $data->data.='>10.2';};
    	Event::bind($hook,$func10_2,10);
    	Event::bind($hook,function($data){ $data->data.='>8';},8);
    	
    	//export(Event::getInstance(),__DIR__.'/~log.log');
    	//return;
    	//#判断该事件点是否绑定有监听器
    	$this->assertTrue(Event::has($hook));
    	$this->assertTrue(!Event::has('hook02'));
    	
    	//绑定一次性的监听器，监听器执行一次后移除，不管事件点触发多少次
    	Event::once($hook,function($data){ $data->data.='>3';},3);
    	
    	//绑定了五个监听器
    	$listeners=Event::getListeners($hook);
    	//export($listeners,__DIR__.'/~log.log');
    	$this->assertTrue(count($listeners)==5);
    	//return;
    	//#触发事件
    	$data=new EventBag('begin:');
    	$res=Event::trigger($hook,$data);
    	//dump($res);dump($data);
    	$this->assertTrue($res===$data);
    	$this->assertTrue($data->oridata=='begin:' && $data->data=='begin:>3>8>10>10.2>12');
    	
    	//绑定了4个监听器,3只执行一次自动移除了
    	$listeners=Event::getListeners($hook);
    	//export($listeners,__DIR__.'/~log.log');
    	$this->assertTrue(count($listeners)==4);
    	
    	//#触发事件
    	$data=new EventBag('begin:');
    	Event::trigger($hook,$data);
    	//dump($data);
    	$this->assertTrue($data->oridata=='begin:' && $data->data=='begin:>8>10>10.2>12');
    	
    	//#解绑事件点指定监听器
    	Event::unbind($hook,$func10_2);
    	
    	//绑定了3个监听器
    	$listeners=Event::getListeners($hook);
    	export($listeners,__DIR__.'/~log.log');
    	$this->assertTrue(count($listeners)==3);
    	
    	//绑定
    	$arr_obj_method12=[new ListenerClass(),'listener12'];
    	Event::bind($hook,$arr_obj_method12,12);
    	Event::bind($hook,[new ListenerClass(),'listener12'],12);
    	Event::bind($hook,[new ListenerClass(),'listener12'],12);
    	Event::bind($hook,[ListenerClass::class,'listener10'],10);
    	Event::bind($hook,[ListenerClass::class,'listener10'],10);
    	Event::bind($hook,[ListenerClass::class,'listener10'],10);
    	$bag=new ListenerBag(function($data){ $data->data.='>bag'; });
    	Event::bind($hook,$bag);
    	Event::bind($hook,$bag);
    	Event::bind($hook,$bag);
    	
    	//绑定了3个监听器
    	$listeners=Event::getListeners($hook);
    	//export($listeners,__DIR__.'/~log.log');
    	$this->assertTrue(count($listeners)==12);
    	
    	//#解绑事件点指定监听器/-3,三个$bag完全相同
    	Event::unbind($hook,$bag);
    	$listeners=Event::getListeners($hook);
    	//export($listeners,__DIR__.'/~log.log');
    	$this->assertTrue(count($listeners)==9);
    	
    	//#解绑事件点指定监听器-1，listener12是数组，数组元素0对象每次也不同，只有一个相等
    	Event::unbind($hook,$arr_obj_method12);
    	$listeners=Event::getListeners($hook);
    	//export($listeners,__DIR__.'/~log.log');
    	$this->assertTrue(count($listeners)==8);
    	
    	//#解绑事件点指定监听器-4，listener10是数组，数组数据都是字符串，总是相等的
    	Event::unbind($hook,[ListenerClass::class,'listener10']);
    	$listeners=Event::getListeners($hook);
    	export($listeners,__DIR__.'/~log.log');
    	$this->assertTrue(count($listeners)==4);
    	
    	//解绑事件点
    	Event::unbind($hook);
    	
    	$this->assertTrue(!Event::has($hook));
    }
}
?>
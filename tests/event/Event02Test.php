<?php
namespace qtests\event;
use qtests\TestCase;
use qing\facades\Event;
use qing\event\EventBag;
use qing\event\ListenerBag;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Event02Test extends TestCase{
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
    	Event::bind($hook,function($data){$data->data.='>12';},12);
    	//优先级相同，先绑定优先级高
    	Event::bind($hook,function($data){$data->data.='>10';},10);
    	Event::bind($hook,function($data){ $data->data.='>10.2';},10);
    	Event::bind($hook,function($data){ $data->data.='>8';},8);
    	
    	//export(Event::getInstance(),__DIR__.'/~log.log');
    	//return;
    	//#判断该事件点是否绑定有监听器
    	$this->assertTrue(Event::has($hook));
    	$this->assertTrue(!Event::has('hook02'));
    	
    	//#触发事件
    	$data=new EventBag('begin:');
    	Event::trigger($hook,$data);
    	//dump($data);
    	$this->assertTrue($data->oridata=='begin:' && $data->data=='begin:>8>10>10.2>12');
    	
    	Event::bind($hook,function($data){
    		$data->data.='>9';
    		//事件结束，不再执行下面的监听器
    		$data->finish=true;
    	},9);
    	
    	//#触发事件
    	$data=new EventBag('begin:');
    	Event::trigger($hook,$data);
    	//dump($data);
    	$this->assertTrue($data->oridata=='begin:' && $data->data=='begin:>8>9');
    		     	
    }
}
?>
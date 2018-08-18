<?php
namespace qtests\url;
use qtests\TestCase;
use qing\url\creators\Path;
// use qing\url\creators\Get;
use qing\url\UrlManager;
use qing\router\Alias;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UrlManager02Test extends TestCase{
    /**
     * 
     */
    public function test(){
    	$alias=new Alias();
    	$alias->setMaps([
    			'add'	=>'add@index',
    			'home'	=>['home','index'],
    			'edit'	=>'main@edit@index',
    			//
    			'user'	=>'u@index@index',
    			'reg'	=>'u@reg@index',
    			'login'	=>'u@login@index',
		]);
    	$alias->setMap('admin'		,'admin@index@index');
    	$alias->setMap('test'		,['test','index','index']);
    	$alias->setMap('test/log'	,['test','log','index']);
    	//dump($alias);
    	    					
    	$manager=new UrlManager();
    	$manager->rootUrl='index.php';
    	//路由别名，同时处理路由解析
    	$manager->pushCreator($alias);
    	$manager->pushCreator(new Path());
    	
    	$url=$manager->create('','add','index',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='index.php/add?id=1');
    	
    	$url=$manager->create('','index','index',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='index.php/index/index?id=1');
    	
    	$url=$manager->create('','edit','',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='index.php/edit?id=1');
    	
    	//dump($manager);
    }
}
?>
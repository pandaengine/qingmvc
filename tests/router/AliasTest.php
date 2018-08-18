<?php
namespace qtests\router;
use qtests\TestCase;
use qing\router\RouteBag;
use qing\router\Alias;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class AliasTest extends TestCase{
    /**
     * 解析路由
     */
    public function testParseRoute(){
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
    	
    	//#路由解析
    	$_SERVER['PATH_INFO']='home';
    	$r=$alias->parse();
    	//dump($r);
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='main' && $r->ctrl=='home' && $r->action=='index');
    	
    	$_SERVER['PATH_INFO']='user';
    	$r=$alias->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='u' && $r->ctrl=='index' && $r->action=='index');
    	
    	$_SERVER['PATH_INFO']='admin';
    	$r=$alias->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='admin' && $r->ctrl=='index' && $r->action=='index');
    	
    	$_SERVER['PATH_INFO']='test/log';
    	$r=$alias->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='test' && $r->ctrl=='log' && $r->action=='index');
    	 
    	
    	//#路由生成
    	$url=$alias->create('','home','index',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='/home?id=1');
    	
    	$url=$alias->create('main','edit','index');
    	$this->assertTrue($url=='/edit');
    	
    	$url=$alias->create('u','reg','index');
    	$this->assertTrue($url=='/reg');
    	
    	$url=$alias->create('test','log','index',['id'=>2]);
    	$this->assertTrue($url=='/test/log?id=2');
    	//dump($alias);
    }
}
?>
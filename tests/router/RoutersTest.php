<?php
namespace qtests\router;
use qtests\TestCase;
use qing\router\RouteBag;
use qing\router\ParserInterface;
use qing\router\Alias;
use qing\router\Router;
use qing\router\parser\PathInfoParser;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class RoutersTest extends TestCase{
    /**
     * 解析路由
     */
    public function test(){
    	$router=new Router();
    	$router->index=['index','index'];
    	//
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
    	
    	$pathinfo=new PathInfoParser();
    	//
    	$router->pushParser($alias);
    	$router->pushParser($pathinfo);
    	
    	//dump($router);
    	
    	//#路由解析
    	$_SERVER['PATH_INFO']='home';
    	$r=$router->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='main' && $r->ctrl=='home' && $r->action=='index');
    	
    	$_SERVER['PATH_INFO']='user';
    	$r=$router->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='u' && $r->ctrl=='index' && $r->action=='index');
    	
    	$_SERVER['PATH_INFO']='test/log';
    	$r=$router->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='test' && $r->ctrl=='log' && $r->action=='index');
    	
    	$_SERVER['PATH_INFO']='login2/index';
    	$r=$router->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='main' && $r->ctrl=='login2' && $r->action=='index');
    	
    	$_SERVER['PATH_INFO']='login3';
    	$r=$router->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='main' && $r->ctrl=='login3' && $r->action=='index');
    	
    	//模块
    	$_SERVER['PATH_INFO']='.admin';
    	$r=$router->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='admin' && $r->ctrl=='index' && $r->action=='index');
    	
    	$_SERVER['PATH_INFO']='.admin/setting';
    	$r=$router->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='admin' && $r->ctrl=='setting' && $r->action=='index');
    	 
    }
}
?>
<?php
namespace qtests\router;
use qtests\TestCase;
use qing\router\parser\PathInfoParser;
use qing\router\RouteBag;
use qing\router\ParserInterface;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class PathinfoTest extends TestCase{
    /**
     * 
     */
    public function test(){
    	$parser=new PathInfoParser();
    	
    	$_SERVER['PATH_INFO']='';
    	$r=$parser->parse();
    	$this->assertTrue($r==ParserInterface::INDEX);
    	//有模块
    	$_SERVER['PATH_INFO']='.u/user/index';
    	$r=$parser->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='u' && $r->ctrl=='user' && $r->action=='index');
    	
    	$_SERVER['PATH_INFO']='.u/user';
    	$r=$parser->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='u' && $r->ctrl=='user' && $r->action=='index');
    	
    	$_SERVER['PATH_INFO']='.u';
    	$r=$parser->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='u' && $r->ctrl=='index' && $r->action=='index');
    	 
    	//无模块
    	$_SERVER['PATH_INFO']='user/index';
    	$r=$parser->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='main' && $r->ctrl=='user' && $r->action=='index');
    	//
    	$_SERVER['PATH_INFO']='user/index/id/123/name/xiaowang';
    	$r=$parser->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='main' && $r->ctrl=='user' && $r->action=='index');
    	$this->assertTrue($_GET['id']==123 && $_GET['name']=='xiaowang');
    }
}
?>
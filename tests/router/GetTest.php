<?php
namespace qtests\router;
use qtests\TestCase;
use qing\router\RouteBag;
use qing\router\ParserInterface;
use qing\router\parser\GetParser;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class GetTest extends TestCase{
    /**
     * 
     */
    public function test(){
    	$parser=new GetParser();
    	//
    	$_GET=[];
    	$r=$parser->parse();
    	$this->assertTrue($r==ParserInterface::INDEX);
    	//
    	parse_str('m=u&c=Index&a=login&id=123&name=xiaowang',$_GET);
    	$r=$parser->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='u' && $r->ctrl=='Index' && $r->action=='login');
    	$this->assertTrue($_GET['id']==123 && $_GET['name']=='xiaowang');
    	//
    	parse_str('c=user&a=index',$_GET);
    	$r=$parser->parse();
    	$this->assertTrue($r instanceof RouteBag);
    	$this->assertTrue($r->module=='main' && $r->ctrl=='user' && $r->action=='index');
    }
}
?>
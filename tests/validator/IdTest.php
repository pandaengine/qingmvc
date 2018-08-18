<?php
namespace qtests\validator;
use qtests\TestCase;
use qing\validator\Id;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class IdTest extends TestCase{
    /**
     * 
     */
    public function test(){
    	$id='c4ca4238a0b923820dcc509a6f75849b';
    	$this->assertTrue(Id::validate($id));
    	$this->assertTrue(Id::validate($id,32));
    	$this->assertTrue(Id::validate(substr($id,0,16),16));
    	
    	$this->assertFalse(Id::validate($id.'+'));
    	$this->assertFalse(Id::validate(substr($id,1)));
    }
}
?>
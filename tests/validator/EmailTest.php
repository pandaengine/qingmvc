<?php
namespace qtests\validator;
use qtests\TestCase;
use qing\validator\Email;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class EmailTest extends TestCase{
	/**
	 * @see \qtests\TestCase::setUp()
	 */
    protected function setUp(){
        parent::setUp();
    }
    /**
     * 
     */
    public function test(){
    	//验证用户名段，只允许字母数字减号
    	$this->assertFalse(Email::validate('qingmvc\'\'""\\1\23$-_.+!*\'{}|^~[]`#%/?@&=@q\'"q.com'));
    	//域名减号
    	$this->assertFalse(Email::validate('qing*mvc@q-q.com'));
    	$this->assertFalse(Email::validate('qing_mvc@qq.com'));
    	$this->assertFalse(Email::validate('qing"mvc@qq.com'));
    	//
    	$this->assertFalse(Email::validate('qingmvc@-demo.qq.com'));
    	$this->assertFalse(Email::validate('qingmvc@-qq.com'));
    	//@
    	$this->assertFalse(Email::validate('qingmvc@demo@qq.com'));
    	$this->assertFalse(Email::validate('qingmvc@q@q.com'));
    	//
    	$this->assertTrue(Email::validate('qing-mvc@q-q.com'));
    	$this->assertTrue(Email::validate('qing-mvc@qq.com'));
    }
}
?>
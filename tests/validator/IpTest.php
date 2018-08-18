<?php
namespace qtests\validator;
use qtests\TestCase;
use qing\validator\Ip;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class IpTest extends TestCase{
    /**
     * 
     */
    public function test(){
    	$ip = "192.168.0.1";
    	$this->assertTrue(Ip::validate($ip));
    	$this->assertTrue(Ip::ipv4($ip));
    	$this->assertFalse(Ip::ipv6($ip));
    	
    	$ip="2001:0db8:85a3:08d3:1319:8a2e:0370:7334";
    	$this->assertTrue(Ip::validate($ip));
    	$this->assertFalse(Ip::ipv4($ip));
    	$this->assertTrue(Ip::ipv6($ip));
    	//
    	$this->assertTrue(Ip::validate('127.0.0.1'));
    	$this->assertTrue(Ip::validate('0.0.0.0'));
    	$this->assertTrue(Ip::validate('255.255.255.255'));
    	//
    	$this->assertFalse(Ip::validate('255.255.255'));
    	$this->assertFalse(Ip::validate('255.255.255.256'));
    	$this->assertFalse(Ip::validate('255.255.25-5.1'));
    	$this->assertFalse(Ip::validate('.255.255.1'));
    }
}
?>
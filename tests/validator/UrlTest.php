<?php
namespace qtests\validator;
use qtests\TestCase;
use qtests\Conf;
use qing\validator\Url;
use qing\validator\UrlValidator;
use qing\validator\Domain;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UrlTest extends TestCase{
    /**
     * 链接测试用例
     */
    public function testUrl(){
    	//没有scheme/http://
    	$this->assertFalse(Url::validate('qingmvc.com'));
    	//scheme
    	$this->assertFalse(Url::validate('htt://qingmvc.com'));
    	$this->assertTrue(Url::validate('htt://qingmvc.com',['htt','ftp']));
    	//域名格式错误
    	$this->assertFalse(Url::validate('http://invalid,domain'));
    	$this->assertFalse(Url::validate('http://'.Conf::evil_str));
    	
    	$this->assertTrue(Url::validate('http://qingmvc.com'));
    	$this->assertTrue(Url::validate('https://qingmvc.com'));
    	
    	//危险url也通过
    	$url='http://qingmvc.com/path/a/b/c?name=哈哈&age=37&code=<b>\'123\'</b>';
    	$this->assertTrue(Url::validate($url));
    	//query里有中文: 总是失败
    	$this->assertFalse(UrlValidator::validate($url));
    	//query没有中文
    	$this->assertTrue(UrlValidator::validate('http://qingmvc.com/path/a/b/c?name=xiaowang&age=37'));
    }
    /**
     * 域名测试用例
     */
    public function testDomain(){
    	//减号-不在开头或结尾
    	$this->assertFalse(Domain::validate('-qingmvc.com'));
    	$this->assertFalse(Domain::validate('qingmvc-.com'));
    	//子域名减号比较随意，无法精细判断
    	$this->assertTrue(Domain::validate('v2.demo-.qingmvc.com'));
    	$this->assertTrue(Domain::validate('v2.-demo.qingmvc.com'));
    	//
    	$this->assertTrue(Domain::validate('qingmvc.com'));
    	$this->assertTrue(Domain::validate('qing-mvc.com.wang.cn'));
    	$this->assertTrue(Domain::validate('s.1-9.v6.demo.qingcms.com'));
    	$this->assertTrue(Domain::validate('s.1-9.v6.de-mo.qingcms.wangcn'));
    }
}
?>
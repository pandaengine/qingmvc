<?php
namespace qtests\url;
use qtests\TestCase;
use qing\url\creators\Path;
use qing\url\creators\Get;
use qing\url\creators\RPath;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UrlManager01Test extends TestCase{
    /**
     * 
     */
    public function testPath(){
    	$path=new Path();
    	
    	$url=$path->create('','index','index',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='/index/index?id=1');
    	
    	$url=$path->create('','reg','',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='/reg?id=1');
    	
    	$url=$path->create('u','profile','index',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='/.u/profile/index?id=1');
    	
    	$url=$path->create('u','profile','',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='/.u/profile?id=1');
    }
    /**
     *
     */
    public function testGet(){
    	$get=new Get();
    	
    	$url=$get->create('','index','index',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='?c=index&a=index&id=1');
    	 
    	$url=$get->create('u','profile','index',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='?m=u&c=profile&a=index&id=1');
    	
    	$url=$get->create('u','profile','',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='?m=u&c=profile&id=1');
    }
    /**
     *
     */
    public function testRPath(){
    	$c=new RPath();
    	 
    	$url=$c->create('','index','index',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='?r=/index/index&id=1');
    
    	$url=$c->create('u','profile','index',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='?r=/.u/profile/index&id=1');
    	 
    	$url=$c->create('u','profile','',['id'=>1]);
    	//dump($url);
    	$this->assertTrue($url=='?r=/.u/profile&id=1');
    }
}
?>
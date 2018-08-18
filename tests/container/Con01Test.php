<?php
namespace qtests\container;
use qing\facades\Container;
class AAA{
	public $name='aaa';
}
class BBB{
	public $name='bbb';
}
class CCC{
	public $name='ccc';
	public $aaa;
	public $bbb;
}
/**
 * 
 * @see app/config/main.php
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Con01Test extends Base{
    /**
     * 
     */
    public function test(){
    	$res=Container::set('aaa',AAA::class);
    	$res=Container::set('bbb',BBB::class);
    	$res=Container::set('closure',function(){
    		return new BBB();
    	});
    	$res=Container::set('ccc',['class'=>CCC::class,'aaa'=>'aaa','bbb'=>'bbb']);
    	//
    	$aaa=Container::get('aaa');
    	$this->assertTrue(is_object($aaa) && $aaa instanceof AAA);
    	$bbb=Container::get('bbb');
    	$this->assertTrue(is_object($bbb) && $bbb instanceof BBB);
    	$func=Container::get('closure');
    	$this->assertTrue(is_object($func) && $func instanceof BBB);
    	//实例ccc依赖aaa&bbb
    	$ccc=Container::get('ccc');
    	$this->assertTrue(is_object($ccc) && $ccc instanceof CCC);
    	$this->assertTrue($ccc->aaa===$aaa && $ccc->bbb===$bbb);
    	//
    	//$con=Coms::get('container');
    	//dump(Container::getInstance());
    }
    /**
     * 实例分类
     * 
     * @see app/config/main.php
     */
    public function testCat(){
    	$di=Container::get('M:Sites');
    	$this->assertTrue(is_object($di) && $di instanceof \main\model\Sites);
    	$di=Container::get('M:sites');
    	$this->assertTrue(is_object($di) && $di instanceof \main\model\Sites);
    	//
    	$di=Container::get('C:Index');
    	$this->assertTrue(is_object($di) && $di instanceof \main\controller\Index);
    	$di=Container::get('C:index');
    	$this->assertTrue(is_object($di) && $di instanceof \main\controller\Index);
    	
    }
}
?>
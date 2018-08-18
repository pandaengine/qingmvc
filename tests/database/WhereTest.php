<?php
namespace qtests\database;
use qtests\TestCase;
use qing\db\Where;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class WhereTest extends TestCase{
	/**
	 * 不绑定预处理参数
	 */
	public function testUnBind(){
		$bindOn=false;
		//
		$where=new Where();
		$where->like('title','%abc%');
		$where->gleft(Where::O_R);//分组(
		$where->eq('id',123);
		$where->gt('age',18);
		$where->eq('name','xiaowang');
		$where->gright();//分组)
		$where->in('cat',[111,222,333]);
		 
		//var_dump($where->getWhere(false));
		//var_dump($where->getBindings());
		
		$file=__DIR__.'/WhereTest_testUnBind.txt';
		//file_put_contents($file,$where->getWhere($bindOn));
		$this->assertContains(file_get_contents($file),$where->getWhere($bindOn));
		$this->assertEquals([],$where->getBindings());
	}
    /**
     * 绑定预处理参数
     */
    public function testBind(){
    	$bindOn=true;
    	//
    	$where=new Where();
    	$where->like('title','%abc%');
    	
    	$this->assertContains('title like ?',$where->getWhere($bindOn));
    	$this->assertEquals([['title','%abc%']],$where->getBindings());
    	
    	//
    	$where=new Where();
    	$where->like('title','%abc%');
    	$where->gleft(Where::O_R);//分组(
    	$where->eq('id',123);
    	$where->gt('age',18);
    	$where->eq('name','xiaowang');
    	$where->gright();//分组)
    	$where->in('cat',[111,222,333]);
    	
    	//var_dump($where->getWhere());
    	//var_dump($where->getBindings());
    	
    	$this->assertContains('title like ? or (  id = ? and age > ? and name = ?  ) and cat in (?,?,?)',$where->getWhere($bindOn));
    	$this->assertEquals(
    			[
    				['title','%abc%'],['id',123],['age',18],['name','xiaowang'],
    				['cat',111],['cat',222],['cat',333]
    			],$where->getBindings());
    	 
    	
    }
}
?>
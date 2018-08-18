<?php
namespace qtests\db\transaction;
use qing\facades\Model;
/**
 * 不支持事务，总是表锁
 * 
 * # 不支持事务
 * - 回滚无效
 * - 提交，总是提交
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MyISamTest extends Base{
	/**
	 * 测试用例开始
	 */
	protected function setUp(){
		//截断表
		$this->truncateTable(QTESTS_TABLE_MYISAM);
	}
	/**
	 */
	public function testRollback(){
		$table=QTESTS_TABLE_MYISAM;
		
		//#开启事务
		$res=Model::begin();
		$this->assertTrue($res===true);
		
		//insert插入数据，其实插入即提交，保存到物理数据
		$res=Model::table($table)->insert(['title'=>'xiaowang1','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==1);//1
		//dump($res);
		
		//#回滚事务
		$res=Model::rollback();
		
		//事务回滚无效，插入数据成功
		$res=Model::table($table)->where(['id'=>1])->find();
		//dump($res);
		$this->assertTrue(is_array($res) && $res['title']=='xiaowang1' && $res['id']==1);
	}
	/**
	 */
	public function testCommit(){
		$table=QTESTS_TABLE_MYISAM;
		
		//#开启事务
		$res=Model::begin();
		$this->assertTrue($res===true);
		
		//insert插入数据，其实插入即提交，保存到物理数据
		$res=Model::table($table)->insert(['title'=>'xiaowang1','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==1);//1
		//dump($res);
		
		//#提交事务
		Model::commit();
		
		//事务提交，修改保存到了物理空间
		$res=Model::table($table)->where(['id'=>1])->find();
		//dump($res);
		$this->assertTrue(is_array($res) && $res['title']=='xiaowang1' && $res['id']==1);
	}
}
?>
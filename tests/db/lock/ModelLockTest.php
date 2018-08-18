<?php
namespace qtests\db\lock;
use qing\facades\Model;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ModelLockTest extends Base{
	/**
	 * 测试用例开始
	 */
	protected function setUp(){
		parent::setUp();
		//插入测试数据
		$this->initData();
	}
	/**
	 * myisam表初始化
	 */
	protected function _init(){
		$table=QTESTS_TABLE_MYISAM;
		//截断表
		$this->truncateTable($table);
		//插入测试数据
		$this->initData($table);
	}
	/**
	 */
	public function test(){
		$this->_init();
		$table=QTESTS_TABLE_MYISAM;
		//#重置主连接
		$conn=$this->getNewConn();
		//克隆对象
		$conn2=clone $conn;
		//关闭debug，超时错误不会抛出异常
		$conn->debug=false;
		$conn2->debug=false;
		
		//conn1锁表读
		$res=Model::lockTablesRead($table);
		$this->assertTrue($res);
		
		$res=Model::unlockTables();
		$this->assertTrue($res);
		
		$res=Model::table($table)->lockTablesWrite();
		$this->assertTrue($res);
		
		$res=Model::unlockTables();
		$this->assertTrue($res);
	}
	/**
	 * innodb
	 * FOR UPDATE
	 */
	public function testForUpdate(){
		$table=QTESTS_TABLE;
		//主连接重置
		$conn=$this->getNewConn();
		$conn2=clone $conn;
		//关闭debug，超时错误不会抛出异常
		$conn->debug=false;
		$conn2->debug=false;
		//dump($conn);dump($conn2);
		
		//事务等待锁的超时秒数
		$this->setTimeouts($conn,$conn2);
		
		//#conn开启一个事务，并不提交，一直占用该连接
		$res=Model::begin();
		$this->assertTrue($res===true);
		
		//显式获取读锁排它锁，
		//id主键行，使用主键索引，仅仅锁定行id=1，行锁，仅锁定该行
		$res=Model::table($table)->where(['id'=>1])->forUpdate()->find();
		//dump($res);dump(Model::getSql());
		$this->assertTrue(is_array($res) && $res['title']=='t1');
		$this->assertTrue(preg_match('/for\s+update/i',Model::getSql())>0);
		//#conn2连接
		//#不会阻塞
		//读取锁定行，不会阻塞，快照读，非锁定读
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t1');
		
		//#会阻塞
		//读取锁定行，申请读锁排他锁，行锁冲突争用
		//$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1 FOR UPDATE ");
		//$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		//读取锁定行，申请读锁共享锁，行锁冲突争用
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1 LOCK IN SHARE MODE");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		
		Model::commit();
	}
	/**
	 * innodb
	 * LOCK IN SHARE MODE
	 */
	public function testLockShare(){
		$table=QTESTS_TABLE;
		//主连接重置
		$conn=$this->getNewConn();
		$conn2=clone $conn;
		//关闭debug，超时错误不会抛出异常
		$conn->debug=false;
		$conn2->debug=false;
		//dump($conn);dump($conn2);
		
		//事务等待锁的超时秒数
		$this->setTimeouts($conn,$conn2);
		
		//#conn开启一个事务，并不提交，一直占用该连接
		$res=Model::begin();
		$this->assertTrue($res===true);
		
		//显式获取读锁共享锁
		//id主键行，使用主键索引，仅仅锁定行id=1，行锁，仅锁定该行
		$res=Model::table($table)->where(['id'=>1])->lockShare()->find();
		//dump($res);dump(Model::getSql());
		$this->assertTrue(is_array($res) && $res['title']=='t1');
		$this->assertTrue(preg_match('/LOCK\s+IN\s+SHARE\s+MODE/i',Model::getSql())>0);
		//#conn2连接
		//#不会阻塞
		//读取锁定行，不会阻塞，快照读，非锁定读
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t1');
		
		//#会阻塞
		//读取锁定行，申请读锁排他锁，行锁冲突争用
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1 FOR UPDATE ");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		//读取锁定行，申请读锁共享锁，行锁
		//可以共享
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1 LOCK IN SHARE MODE");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t1');
		
		Model::commit();
	}
}
?>
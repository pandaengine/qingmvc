<?php
namespace qtests\db\lock;
use qing\db\ddl\Transaction;
/**
 * 读锁-排它锁
 * innodb事务
 * 
 * @link X:\@git\mysql_test\lock.for+update\demo001.md
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ForUpdateTest extends Base{
	/**
	 * 行锁
	 * - 自动事务的连接，事务超时之后，锁被释放？
	 * 
	 * 注意：使用到了锁等待超时，至少1秒，所以这些测试用例用时较长！
	 */
	public function testRowLock(){
		//插入测试数据 
		$this->initData();
		//
		$table=QTESTS_TABLE;
		//#第二连接，创建一个空连接
		$conn=$this->getNewConn2();
		//克隆对象
		$conn2=clone $conn;
		//关闭debug，超时错误不会抛出异常
		$conn->debug=false;
		$conn2->debug=false;
		//dump($conn);dump($conn2);
		
		//事务等待锁的超时秒数
		$timeout=1;
		$this->setTimeout($conn,$timeout);
		$this->setTimeout($conn2,$timeout);
		//事务隔离级别保持默认：可重复读(Repeatable read)
		$isolation=$conn->query(Transaction::getIsolation());
		//dump($isolation);
		$this->assertTrue(current(current($isolation))==Transaction::REPEATABLE_READ);
		
		//#conn开启一个事务，并不提交，一直占用该连接
		$res=$conn->begin();$this->assertTrue($res===true);
		//显式获取读锁排它锁，
		//id主键行，使用主键索引，仅仅锁定行id=1，行锁，仅锁定该行
		$res=$conn->query("SELECT * FROM `{$table}` WHERE id=1 FOR UPDATE ");
		//dump($res);
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t1');
		
		//#conn2连接操作被阻塞，自动事务
		//#不会阻塞
		//读取锁定行，不会阻塞，快照读，非锁定读
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t1');
		//dump($res);dump($conn2->getError());
		//读取非锁定行，不会阻塞，非锁定读，快照读？
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=2");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t2');
		//dump($res);dump($conn2->getError());
		//读取非锁定行，申请读锁排他锁，行锁
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=3 FOR UPDATE ");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t3');
		//读取非锁定行，申请读锁共享锁，行锁
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=4 LOCK IN SHARE MODE");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t4');
		//插入，不会阻塞
		$res=$conn2->execute("INSERT INTO `{$table}` (`title`) VALUES ('t111')");
		$this->assertTrue($res===true);
		//更新非锁定行，不会阻塞，申请行锁
		$res=$conn2->execute("UPDATE `{$table}` SET `title`='t55' WHERE (`id`=5)");
		$this->assertTrue($res===true);
		//删除非锁定行，不会阻塞
		$res=$conn2->execute("DELETE FROM `{$table}` WHERE (`id`=6)");
		$this->assertTrue($res===true);
		//
		//return;
		//#会阻塞
		//读取锁定行，申请读锁排他锁，行锁冲突争用
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1 FOR UPDATE ");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		//读取锁定行，申请读锁共享锁，行锁冲突争用
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1 LOCK IN SHARE MODE");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		
		//更新锁定行，使用索引，申请行锁，行锁冲突争用
		$res=$conn2->execute("UPDATE `{$table}` SET `title`='t11' WHERE (`id`=1)");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		//dump($res);
		//dump($conn2->getError());
		
		//#确保上面的表锁在事务超时后被释放，申请个行锁试试
		//#确保行可以获得锁
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=2 FOR UPDATE ");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t2');
		
		//##表锁
		//读取非锁定行，申请读锁排他锁，未使用到索引，申请表锁，conn1的行锁未释放，表锁申请等待
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE name='n2' FOR UPDATE ");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		//读取非锁定行，共享表锁
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE name='n3' LOCK IN SHARE MODE");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		//更新非锁定行，写锁表锁无法获得
		$res=$conn2->execute("UPDATE `{$table}` SET `name`='n44' WHERE (`name`='n4')");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		
		//#确保上面的表锁在事务超时后被释放，申请个行锁试试
		//#确保行可以获得锁
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=3 FOR UPDATE ");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t3');
		
		//提交下
		$conn->commit();
	}
}
?>
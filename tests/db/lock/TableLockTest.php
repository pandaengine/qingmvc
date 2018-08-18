<?php
namespace qtests\db\lock;
use qing\db\ddl\Transaction;
/**
 * innodb事务-表锁
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class LockTest extends Base{
	/**
	 */
	public function test(){
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
		//申请写锁表锁
		//没有使用索引，使用表锁
		$res=$conn->execute("UPDATE `{$table}` SET `title`='t11' WHERE (`name`='n1')");
		$this->assertTrue($res);
		
		//#conn2连接操作被阻塞，自动事务
		
		//#不会阻塞
		//##非锁定读，快照读
		//读取锁定行，不会阻塞，快照读，非锁定读
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t1');
		//dump($res);dump($conn2->getError());
		//读取非锁定行，不会阻塞，非锁定读，快照读？
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=2");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t2');
		
		//#阻塞
		//读取非锁定行，申请读锁排他锁，行锁
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=3 FOR UPDATE ");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		//读取非锁定行，申请读锁共享锁，行锁
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=4 LOCK IN SHARE MODE");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		
		//表锁存在，行锁 需要等待
		//无法插入，已锁定表
		$res=$conn2->execute("INSERT INTO `{$table}` (`title`) VALUES ('t111')");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		//更新非锁定行，申请行锁
		$res=$conn2->execute("UPDATE `{$table}` SET `title`='t55' WHERE (`id`=5)");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		//删除非锁定行
		$res=$conn2->execute("DELETE FROM `{$table}` WHERE (`id`=6)");
		$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		
		//提交
		$conn->commit();
	}
}
?>
<?php
namespace qtests\db\transaction;
use qing\db\ddl\Transaction;
/**
 * 不可重复读
 * 一个事务内两次读到的数据是不一样的，因此称为是不可重复读
 * 死锁超时，耗时较长
 * 
 * # 可串行化(Serializable)可能导致死锁
 * SHOW FULL PROCESSLIST
 * 
 * @link X:\@git\mysql_test\transaction.acid.Isolation
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NonRepeatableReadTest extends Base{
	/**
	 */
	public function test(){
		$table=QTESTS_TABLE;
		//#第二连接，创建一个空连接
		$conn=$this->getNewConn2();
		//克隆对象
		$conn2=clone $conn;
		//dump($conn);dump($conn2);
		
		//事务等待锁的超时秒数
		$this->setTimeouts($conn,$conn2);
		
		//#未提交读(Read uncommitted)，不可重复读取
		$this->setIsolations($conn,$conn2,Transaction::READ_UNCOMMITTED);
		$this->check($conn,$conn2,false);//不可重复读
		
		//#已提交读(Read committed)
		$this->setIsolations($conn,$conn2,Transaction::READ_COMMITTED);
		$this->check($conn,$conn2,false);//不可重复读
		
		//#可重复读(Repeatable read)
		$this->setIsolations($conn,$conn2,Transaction::REPEATABLE_READ);
		$this->check($conn,$conn2,true);//可重复读
		
		//锁竞争，导致死锁,SHOW FULL PROCESSLIST
		//conn1事务没有提交，conn2事务需要等待conn1完成?conn2无法完成修改阻塞
		//#可串行化(Serializable)
		//两条事务都串行化了，conn2永远等不到conn1释放锁
		$this->setIsolations($conn,$conn2,Transaction::SERIALIZABLE);
		$this->check($conn,$conn2,true,true);//可重复读
	}
	/**
	 * 检测
	 * 
	 * @param \qing\db\Connection $conn
	 * @param \qing\db\Connection $conn2
	 * @param string $canRepeatRead
	 * @param boolean $canRepeatRead 是否可重复读
	 * @param boolean $deadLock	是否发生死锁超时
	 */
	protected function check($conn,$conn2,$canRepeatRead,$deadLock=false){
		//#截断表,必须/conn2有修改数据/虽然conn1回滚，到已有数据物理化了?
		$this->truncateTable();
		//
		$table=QTESTS_TABLE;
		//conn1插入测试数据
		$res=$conn->execute("INSERT INTO `{$table}` (`title`) VALUES ('xiaowang1')");
		$this->assertTrue($res===true);
		
		//#conn1开启事务,读取两次数据
		$res=$conn->begin();$this->assertTrue($res===true);
		
		//conn1第一次读取数据
		$res=$conn->query("SELECT * FROM `{$table}` where id=1 ");
		//dump($res);
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='xiaowang1');
		
		//#conn2开启事务
		//$res=$conn2->begin();$this->assertTrue($res===true);
		//conn2自动提交事务，修改数据
		//串行化时，此处死锁，conn2永远获取不到写锁，死锁
		if($deadLock){
			//关闭debug，超时错误不会抛出异常
			$conn2->debug=false;
		}
		$res=$conn2->execute("UPDATE `{$table}` SET `title`='xiaowang2' WHERE (`id`='1')");
		//dump($res);
		if($deadLock){
			//死锁超时
			$this->isLockWaitTimeout($conn2,$res);
		}else{
			$this->assertTrue($res===true);
		}
		
		//conn1第二次读取数据，如果和第一次数据不同，则不可重复读
		$res=$conn->query("SELECT * FROM `{$table}` where id=1 ");
		//dump($res);
		//$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='xiaowang1');
		if($canRepeatRead){
			//#可重复读，读取的是conn1原来添加的数据
			$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='xiaowang1');
		}else{
			//#不可重复读，读取的是conn2修改后的数据
			$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='xiaowang2');
		}
		
		//#提交事务/回滚事务
		$conn->rollback();
	}
}
?>
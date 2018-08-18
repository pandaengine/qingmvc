<?php
namespace qtests\db\transaction;
use qing\db\ddl\Transaction;
/**
 * 幻读
 * 死锁超时，耗时较长
 * 
 * @link X:\@git\mysql_test\transaction.acid.Isolation
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class PhantomReadTest extends Base{
	/**
	 */
	public function test(){
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
		$this->setTimeouts($conn,$conn2);
		
		//#未提交读(Read uncommitted)
		$this->setIsolations($conn,$conn2,Transaction::READ_UNCOMMITTED);
		$this->check($conn,$conn2,true);//幻读
		
		//#已提交读(Read committed)
		$this->setIsolations($conn,$conn2,Transaction::READ_COMMITTED);
		$this->check($conn,$conn2,true);//幻读
		
		//#可重复读(Repeatable read)
		$this->setIsolations($conn,$conn2,Transaction::REPEATABLE_READ);
		$this->check($conn,$conn2,false,true);//幻读，死锁
		
		//死锁,SHOW FULL PROCESSLIST
		//conn1事务没有提交，conn2事务需要等待conn1完成?conn2无法完成修改阻塞
		//#可串行化(Serializable)
		$this->setIsolations($conn,$conn2,Transaction::SERIALIZABLE);
		$this->check($conn,$conn2,false,true);//不会幻读，死锁
	}
	/**
	 * 检测
	 * 
	 * @param \qing\db\Connection $conn
	 * @param \qing\db\Connection $conn2
	 * @param boolean $is 是否导致幻读
	 * @param boolean $deadLock	是否发生死锁超时
	 */
	protected function check($conn,$conn2,$is,$deadLock=false){
		//#截断表,必须
		$this->truncateTable();
		//
		$table=QTESTS_TABLE;
		//conn1插入测试数据
		$res=$conn->execute("INSERT INTO `{$table}` (`title`) VALUES ('xiaowang1')");
		$this->assertTrue($res===true);
		$res=$conn->execute("INSERT INTO `{$table}` (`title`) VALUES ('xiaowang2')");
		$this->assertTrue($res===true);
		$res=$conn->execute("INSERT INTO `{$table}` (`title`) VALUES ('xiaowang3')");
		$this->assertTrue($res===true);
		
		//#conn1开启事务
		$res=$conn->begin();$this->assertTrue($res===true);
		
		//conn1修改数据，涉及到表中的全部数据行
		//title段有索引
		$res=$conn->execute("UPDATE `{$table}` SET `title`='xiaowang' ");
		//dump($res);
		$this->assertTrue($res===true);
		
		//#conn2开启事务
		//$res=$conn2->begin();$this->assertTrue($res===true);
		//conn2自动提交事务，向表中插入一行新数据
		$res=$conn2->execute("INSERT INTO `{$table}` (`title`) VALUES ('qingmvc2')");
		if($deadLock){
			//死锁，无法获取得到锁
			$this->assertTrue($this->isLockWaitTimeout($conn2,$res));
		}else{
			$this->assertTrue($res===true);
		}
		
		//conn1第二次读取数据，如果读取到conn2新插入的数据，则出现幻读
		$res=$conn->query("SELECT * FROM `{$table}` ");
		//dump($res);
		
		//$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='xiaowang1');
		if($is){
			//#出现幻读，读取到conn2新插入的数据
			$this->assertTrue(is_array($res) && count($res)==4 && $res[3]['title']=='qingmvc2');
		}else{
			//#没有出现幻读，读取不到conn2新插入的数据
			$this->assertTrue(is_array($res) && count($res)==3 && $res[2]['title']=='xiaowang');
		}
		$this->assertTrue($res[0]['title']=='xiaowang');
		
		//#提交事务/回滚事务
		$conn->rollback();
	}
}
?>
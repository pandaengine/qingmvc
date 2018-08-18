<?php
namespace qtests\db\transaction;
use qing\db\ddl\Transaction;
/**
 * 事务隔离测试
 * InnoDB
 * MyIsam不支持事务
 * 
 * @link X:\@git\mysql_test\transaction.acid.Isolation
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class DirtyReadTest extends Base{
	/**
	 * 脏读测试
	 * 
	 * # 脏读:
	 * 当一个事务进行的操作还未提交时，另外一个事务读到了修改的数据，这就是脏读
	 * 
	 * # 未提交读(Read uncommitted)
	 * 未提交读读可能导致该问题，其他事务隔离级别不会出现脏读
	 * 
	 * # 事务隔离级别
	 * - 开启两个不同连接，线程，再分别开启事务
	 * - 一个连接，线程，只能同时打开一个事务
	 * 
	 * @-dep-ends test
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
		
		//#未提交读(Read uncommitted)，会导致脏读
		$this->setIsolations($conn,$conn2,Transaction::READ_UNCOMMITTED);
		$this->isDirtyRead($conn,$conn2,true);//导致脏读
		
		//#已提交读(Read committed)，不会导致脏读
		$this->setIsolations($conn,$conn2,Transaction::READ_COMMITTED);
		$this->isDirtyRead($conn,$conn2,false);//不会导致脏读
		
		//#可重复读(Repeatable read)，不会导致脏读
		$this->setIsolations($conn,$conn2,Transaction::REPEATABLE_READ);
		$this->isDirtyRead($conn,$conn2,false);//不会导致脏读
		
		//#可串行化(Serializable)，不会导致脏读
		//该段代码会导致死锁?不会，conn2自动提交了，如果conn2开启事务且不提交，conn1会阻塞而conn2而无法读取？
		$this->setIsolations($conn,$conn2,Transaction::SERIALIZABLE);
		$this->isDirtyRead($conn,$conn2,false);//不会导致脏读
	}
	/**
	 * 判断是否会导致脏读
	 *
	 * @param string $conn
	 * @param string $conn2
	 * @param string $is 是否会导致脏读
	 */
	protected function isDirtyRead($conn,$conn2,$is){
		$table=QTESTS_TABLE;
		//#conn1开启事务,conn2尝试读取,是否可以读到
		$res=$conn->begin();$this->assertTrue($res===true);
	
		//conn1插入数据
		$res=$conn->execute("INSERT INTO `{$table}` (`title`) VALUES ('xiaowang2')");
		$this->assertTrue($res===true);
		//dump($res);
		
		//#conn2开启事务
		//$res=$conn2->begin();$this->assertTrue($res===true);
		//conn2自动事务
		//conn2尝试读取数据
		$res=$conn2->query("SELECT * FROM `{$table}`");
		//dump($res);
		if($is){
			//#导致脏读，数据不为空
			$this->assertTrue(is_array($res) && count($res)==1);
		}else{
			//#没有脏读，数据空
			$this->assertTrue(is_array($res) && count($res)==0);
		}
	
		//#提交事务/回滚事务
		$conn->rollback();
	}
}
?>
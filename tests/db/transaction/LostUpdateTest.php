<?php
namespace qtests\db\transaction;
use qing\db\ddl\Transaction;
/**
 * 更新丢失（Lost Update）
 * 
 * - 同时读取同一行，取得同一份数据
 * - 更新丢失
 * - 超买
 * 
 * @link X:\@git\mysql_test\transaction.isolation
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class LostUpdateTest extends Base{
	/**
	 */
	public function test(){
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
		$this->check($conn,$conn2,true);//丢失更新，超买
		
		//#已提交读(Read committed)
		$this->setIsolations($conn,$conn2,Transaction::READ_COMMITTED);
		$this->check($conn,$conn2,true);//丢失更新，超买
		
		//#可重复读(Repeatable read)
		$this->setIsolations($conn,$conn2,Transaction::REPEATABLE_READ);
		$this->check($conn,$conn2,true);//丢失更新，超买
		
		//#串行化后，普通select被修改为select for share in mode执行，共享读锁？阻塞了写？
		//conn1的更新操作被conn2共享读锁？阻塞
		//如果的排他读锁，为啥两个事务可以同时读?
		$this->setIsolations($conn,$conn2,Transaction::SERIALIZABLE);
		$this->check($conn,$conn2,false);//不会丢失更新，不会超买
	}
	/**
	 * 检测
	 * - update写锁总是原子一致性的？
	 * - 写锁不能共享，不能竞争？
	 * - 不可能出现两条事务同时修改update的情况！
	 * 
	 * ---
	 * 
	 * # 重点是：同时读取一行数据，读取到一样的数据，再根据该数据更新
	 * 1. 如果是加库存1，两次操作后，最后只添加的一个，好像第一次加库存不存在似得，更新丢失？
	 * 2. 秒杀超卖:两个用户同时抢到最后一个名额/库存，实际只有一件商品，一件商品卖了两次！
	 * 
	 * @param \qing\db\Connection $conn
	 * @param \qing\db\Connection $conn2
	 * @param boolean $lostUpdate 是否导致丢失更新
	 */
	protected function check($conn,$conn2,$lostUpdate){
		//#截断表,必须
		$this->truncateTable();
		//
		$table=QTESTS_TABLE;
		//conn1插入测试数据
		$res=$conn->execute("INSERT INTO `{$table}` (`num`) VALUES (1)");
		$this->assertTrue($res===true);
		$res=$conn->execute("INSERT INTO `{$table}` (`num`) VALUES (1)");
		$this->assertTrue($res===true);
		$res=$conn->execute("INSERT INTO `{$table}` (`num`) VALUES (1)");
		$this->assertTrue($res===true);
		
		//#conn1开启事务
		$res=$conn->begin();$this->assertTrue($res===true);
		//#conn2开启事务
		$res=$conn2->begin();$this->assertTrue($res===true);
		
		//conn1读取行1
		$rows=$conn->query("SELECT * FROM `{$table}` where id=1");
		$this->assertTrue(is_array($rows) && count($rows)==1 && (int)$rows[0]['num']==1);
		
		//conn2同样读取行1，读取到的数据一样
		$rows2=$conn2->query("SELECT * FROM `{$table}` where id=1");
		$this->assertTrue(is_array($rows2) && count($rows2)==1 && (int)$rows2[0]['num']==1);
		
		//修改行1，根据读到的数据库存+1
		$res=$conn->execute("UPDATE `{$table}` SET `num`=".((int)$rows[0]['num']+1)." where id=1");
		//dump($res);
		if($lostUpdate){
			$this->assertTrue($res===true);
		}else{
			//不会丢失更新，conn1写操作被conn2的共享锁？阻塞，死锁
			$this->assertTrue($this->isLockWaitTimeout($conn,$res));
		}
		//conn1提交，此时库存为2
		$conn->commit();
		
		//conn1发起一条自动事务，验证数据
		$rows=$conn->query("SELECT * FROM `{$table}` where id=1");
		if($lostUpdate){
			$this->assertTrue(is_array($rows) && count($rows)==1 && (int)$rows[0]['num']==2);
		}else{
			//不会丢失更新，conn1写操作超时未成功，还是1
			$this->assertTrue(is_array($rows) && count($rows)==1 && (int)$rows[0]['num']==1);
		}
		//conn2同样修改行1，根据读到的数据库存+1
		$res=$conn2->execute("UPDATE `{$table}` SET `num`=".((int)$rows2[0]['num']+1)." where id=1");
		$this->assertTrue($res===true);
		
		//conn2提交，此时库存仍然为2
		$conn2->commit();
		
		//conn1再发起一条自动事务，验证数据
		$rows=$conn->query("SELECT * FROM `{$table}` where id=1");
		$this->assertTrue(is_array($rows) && count($rows)==1 && (int)$rows[0]['num']==2);
	}
}
?>
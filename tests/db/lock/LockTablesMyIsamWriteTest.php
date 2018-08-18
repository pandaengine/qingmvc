<?php
namespace qtests\db\lock;
//use qing\utils\Runtime;
/**
 * - myisam不支持事务，但支持显示锁表
 * - 与事务隔离级别无关？
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class LockTablesMyIsamWriteTest extends Base{
	protected $sleepTime=20;
	/**
	 * 测试用例开始
	 */
	protected function setUp(){
	}
	/**
	 */
	protected function _init(){
		$table=QTESTS_TABLE_MYISAM;
		//截断表
		$this->truncateTable($table);
		//插入测试数据
		$this->initData($table);
	}
	/**
	 * LOCK TABLES pre_tests READ
	 * - 
	 */
	public function test(){
		dump(__METHOD__);
		$this->_init();
		$table=QTESTS_TABLE_MYISAM;
		//#第二连接，创建一个空连接
		$conn=$this->getNewConn2();
		//克隆对象
		$conn2=clone $conn;
		//关闭debug，超时错误不会抛出异常
		$conn->debug=false;
		$conn2->debug=false;
		
		//conn1锁表写 
		$res=$conn->execute($this->lock_tables_write($table));
		$this->assertTrue($res);
		
		//conn2尝试读取，不可以读取
		//$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1");
		//dump($res);
		//$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t1');
		
		//conn2尝试修改，无法修改，死锁
		//$res=$conn2->execute("UPDATE `{$table}` SET `title`='222' WHERE id=1");
		//dump($res);
		//$this->assertTrue($res);
		
		//conn1尝试读取，可以读取
		$res=$conn->query("SELECT * FROM `{$table}` WHERE id=1");
		//dump($res);
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t1');
		
		//conn1尝试修改，无法修改，死锁
		$res=$conn->execute("UPDATE `{$table}` SET `title`='111' WHERE id=1");
		$this->assertTrue($res);
		
		//休眠下
		sleep($this->sleepTime);
		
		//释放表锁
		$res=$conn->execute($this->unlock_tables());
		$this->assertTrue($res);
		
		$this->finish_time_log(__CLASS__);
	}
	/**
	 * - 开启第2个命令行
	 */
	public function testConn2(){
		dump(__METHOD__);
		$table=QTESTS_TABLE_MYISAM;
		//#第二连接，创建一个空连接
		$conn2=$this->getNewConn2();
		
		//阻塞等待，直到用例1完成释放锁
		
		//conn2尝试读取
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1");
		//dump($res);
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='111');
		
		//执行时间在预料之中,在用例1之后即可，等待用例1执行完，当前用例才执行
		$this->assertTrue($this->finish_time_check(__CLASS__));
	}
	/**
	 * - 开启第3个命令行
	 */
	public function testConn3(){
		dump(__METHOD__);
		$table=QTESTS_TABLE_MYISAM;
		//#第3连接，创建一个空连接
		$conn3=$this->getNewConn2();
	
		//阻塞等待，直到用例1完成释放锁
		
		//conn3尝试修改
		$res=$conn3->execute("UPDATE `{$table}` SET `title`='222' WHERE id=1");
		//dump($res);
		$this->assertTrue($res);
	
		//执行时间在预料之中,在用例1之后即可，等待用例1执行完，当前用例才执行
		$this->assertTrue($this->finish_time_check(__CLASS__));
	}
}
?>
<?php
namespace qtests\db;
use qtests\TestCase;
use qing\db\Db;
use qing\facades\Model;
use qing\db\ddl\Transaction;
/**
 * phpunit单元测试，基类
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Base extends TestCase{
	/**
	 * 测试用例开始
	 */
	protected function setUp(){
		parent::setUp();
		//截断表
		$this->truncateTable();
	}
	/**
	 * 测试用例结束
	 */
	protected function tearDown(){
		parent::tearDown();
	}
	/**
	 * 截断表
	 * 使用主连接
	 * 
	 * @param string $table
	 */
	protected function truncateTable($table=QTESTS_TABLE){
		//清空/截断数据表
		$res=Model::execute("TRUNCATE TABLE `{$table}`");
		//dump($res);
		$this->assertTrue($res);
		//count统计数据，数据应该为空
		$res=Model::table($table)->count();
		//dump($res);
		$this->assertTrue($res===0);
	}
	/**
	 * 获取全新的主连接
	 */
	protected function getNewConn(){
		//避免上一个用例已经实例化了，先释放组件
		Db::removeInstance();
		return Db::conn();
	}
	/**
	 * 获取全新的第二连接
	 */
	protected function getNewConn2(){
		//避免上一个用例已经实例化了，先释放组件
		Db::removeInstance('conn2');
		return Db::conn('conn2');
	}
	/**
	 * 事务等待锁的超时秒数
	 *
	 * @param \qing\db\Connection $conn
	 * @param string $time
	 */
	protected function setTimeout($conn,$time=1){
		$res=$conn->execute(Transaction::set_innodb_lock_wait_timeout($time));
		$this->assertTrue($res==true);
		//
		$res=$conn->query(Transaction::get_innodb_lock_wait_timeout());
		//dump($res);
		$this->assertTrue(current(current($res))==$time);
	}
	/**
	 * @param \qing\db\Connection $conn1
	 * @param \qing\db\Connection $conn2
	 * @param string $time
	 */
	protected function setTimeouts($conn1,$conn2,$time=1){
		$this->setTimeout($conn1,$time);
		$this->setTimeout($conn2,$time);
	}
	/**
	 * 判断是否是锁等待超时
	 * 1205:Lock wait timeout exceeded; try restarting transaction
	 *
	 * 注意：使用到了锁等待超时，至少1秒，所以这些测试用例用时较长！
	 *
	 * @param \qing\db\Connection $conn
	 * @param boolean $res
	 */
	protected function isLockWaitTimeout($conn,$res){
		if($res===false){
			$error=$conn->getError();
			return preg_match('/.*?1205.*?Lock\s+wait\s+timeout.*/i',$error)>0;
		}else{
			return false;
		}
	}
	/**
	 * 设置事务隔离级别
	 *
	 * @param \qing\db\Connection $conn
	 * @param string $level
	 */
	protected function setIsolation($conn,$level){
		//连接1，当前连接线程有效
		$isolation=$conn->execute(Transaction::setIsolation($level));
		$this->assertTrue($isolation==true);
		//#查询事务隔离级别
		//连接1
		$isolation=$conn->query(Transaction::getIsolation());
		//dump($isolation);
		$this->assertTrue(current(current($isolation))==$level);
	}
	/**
	 * @param \qing\db\Connection $conn1
	 * @param \qing\db\Connection $conn2
	 * @param string $level
	 */
	protected function setIsolations($conn1,$conn2,$level){
		$this->setIsolation($conn1,$level);
		$this->setIsolation($conn2,$level);
	}
}
?>
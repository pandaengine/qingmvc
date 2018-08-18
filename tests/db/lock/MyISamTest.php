<?php
namespace qtests\db\lock;
/**
 * 不支持事务，总是表锁
 * 
 * # 不支持事务
 * - 回滚无效
 * - 提交，总是提交
 * - 执行即提交，保存到物理数据
 * - 无法模拟同时事务，无法模拟并发事务。
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
		$table=QTESTS_TABLE_MYISAM;
		//截断表
		$this->truncateTable($table);
		//插入测试数据
		$this->initData($table);
	}
	/**
	 * 无法模拟并发处理
	 */
	public function testUpdate(){
		$table=QTESTS_TABLE_MYISAM;
		//#第二连接，创建一个空连接
		$conn=$this->getNewConn2();
		//克隆对象
		$conn2=clone $conn;
		
		$res=$conn->execute("UPDATE `{$table}` SET `title`='t11' WHERE id=1");
		$this->assertTrue($res);
		 
		$res=$conn2->execute("UPDATE `{$table}` SET `name`='n11' WHERE id=1");
		$this->assertTrue($res);
	}
	/**
	 * 无法模拟并发处理
	 * - FOR UPDATE 对myisam无效？
	 * - 只能在事务中使用？
	 * 
	 */
	public function testForUpdate(){
		$table=QTESTS_TABLE_MYISAM;
		//#第二连接，创建一个空连接
		$conn=$this->getNewConn2();
		//克隆对象
		$conn2=clone $conn;
		
		$res=$conn->query("SELECT * FROM `{$table}` WHERE id=1 FOR UPDATE ");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t1');
		
		$res=$conn2->query("SELECT * FROM `{$table}` WHERE id=1 FOR UPDATE");
		$this->assertTrue(is_array($res) && count($res)==1 && $res[0]['title']=='t1');
	}
}
?>
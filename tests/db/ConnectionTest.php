<?php
namespace qtests\db;
/**
 * 测试连接
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ConnectionTest extends Base{
	/**
	 */
	public function test(){
		$conn=$this->getNewConn();
    	//dump($conn);
    	$this->assertEquals($conn->type,'mysql');
	}
	/**
	 * 数据库连接开关测试
	 * 
	 * @see \qing\db\ddl\MysqlDDL
	 */
	public function testConnectClose(){
		$db=$this->getNewConn();
		//连接未打开,conn===null
		$conn=$this->privateProperty($db,'conn');
		$this->assertTrue($conn===null);
	
		//打开连接
		$db->getConn();
		$conn=$this->privateProperty($db,'conn');
		$this->assertTrue($conn!==null);
		$this->assertTrue($conn instanceof \PDO);
		//$stmt=$conn->prepare('SHOW FULL PROCESSLIST');
		$stmt=$conn->prepare('SHOW TABLES');
		$res=$stmt->execute();
		$list=$stmt->fetchAll(\PDO::FETCH_ASSOC);
		//pdo执行一条语句
		//var_dump($res);var_dump($list);exit();
		$this->assertTrue($res);
		$this->assertTrue(current(current($list))==QTESTS_TABLE);
		
		//关闭连接
		$db->close();
		$conn=$this->privateProperty($db,'conn');
		$this->assertTrue($conn===null);
		
	}
}
?>
<?php
namespace qtests\db;
use qing\facades\Conn;
//use qing\db\Db;
/**
 * 连接数，线程数
 * - mysql单进程多线程工作模式
 * - 连接的创建和关闭
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ProcessTest extends Base{
	/**
	 * 测试用例开始
	 */
	protected function setUp(){
	}
	/**
	 * 确保没有其他程序开启连接
	 * - SHOW FULL PROCESSLIST
	 * - select  *  from information_schema.`PROCESSLIST`
	 * - navicat关闭后，连接线程释放
	 * - php脚本执行完后，连接线程释放
	 * 
	 */
	public function test(){
		$sql='SHOW FULL PROCESSLIST';
		//#主连接，查看线程数，连接数
		$list=Conn::query($sql);
		//查询得当前连接数
		$connNums=count($list);
		//dump($connNums);
		
		//#第二连接
		$conn=$this->getNewConn2();
		//conn被拷贝，不过这里的conn未连接创建而已
		$conn2=clone $conn;
		$conn3=clone $conn;
		
		//新建一个连接,连接数+1
		$list=$conn->query($sql);
		//dump(count($list));
		$this->assertTrue(count($list)==$connNums+1);
		
		//新建一个连接,连接数+1
		$list=$conn2->query($sql);
		//dump(count($list));
		$this->assertTrue(count($list)==$connNums+2);
		
		//新建一个连接,连接数+1
		$list=$conn3->query($sql);
		//dump(count($list));
		$this->assertTrue(count($list)==$connNums+3);
		
		//主连接，$conn3已经创建，多次请求不会创建新连接
		$list=$conn3->query($sql);
		$nums=Conn::query($sql);
		$this->assertTrue(count($list)==$connNums+3);
		$this->assertTrue(count($nums)==$connNums+3);
		$_connNums=count($nums);
		
		//#关闭连接测试
		//关闭连接3,连接数-1
		$conn3->close();
		$nums=Conn::query($sql);
		//dump(count($nums));
		$this->assertTrue(count($nums)==$_connNums-1);
		
		//关闭连接2,连接数-1
		$conn2->close();
		$nums=Conn::query($sql);
		//dump(count($nums));
		$this->assertTrue(count($nums)==$_connNums-2);
		
		//使用主连接来杀死连接，不要杀死自己？
		$pid=$nums[count($nums)-1]['Id'];
		$kill='kill '.$pid;
		//kill pid,杀死一个连接，连接数-1
		$res=Conn::execute($kill);
		$this->assertTrue($res==true);
		//
		$nums=Conn::query($sql);
		//dump(count($nums));
		$this->assertTrue(count($nums)==$_connNums-3);
	}
}
?>
<?php
namespace qing\db\mysql;
use qing\db\Connection;
use mysqli;
/**
 * Mysqli面向过程的写法/数据库驱动/数据库访问对象
 * 
 * @property \mysqli $conn
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MysqliProcessConnection extends Connection{
	/**
	 * 数据库版本
	 * 
	 * @var string
	 */
	public $version;
	/**
	 * 创建数据库连接
	 */
	public function connect(){
		try{
			$mysqli=@mysqli_connect($this->host,$this->user,$this->pwd,$this->name,$this->port);
			//规定 SQL 连接标识符。如果未规定，则使用上一个打开的连接。
			if(mysqli_connect_errno()){
				throw new \Exception('Db::Mysqli Connect Error: '.iconv('GB2312','UTF-8',mysqli_connect_error()));
			}
		}catch(\Exception $e){
			throw $e;
		}
		//数据库版本
		$this->version=mysqli_get_server_info($mysqli);
		//设置数据库编码
		mysqli_set_charset($mysqli,$this->charset);
		return $mysqli;
	}
	/**
	 * 执行查询，返回数据
	 * ---
	 * @uses \mysqli ::query()
	 * false on failure. 
	 * For successful SELECT, SHOW, DESCRIBE or EXPLAIN queries mysqli_query will return a mysqli_result object. 
	 * For other successful queries mysqli_query will return true.
	 * ---
	 * @see  \qing\db\Connection ::query()
	 * @uses \mysqli_result 
	 * @return array
	 */
	public function query($sql,array $params=[]){
		if($params){
			throw new \Exception('数据库驱动'.__METHOD__.'不支持预处理');
		}
		$mysqli=$this->getConn();
		$result=mysqli_query($mysqli,$sql);
		if($result===false){
			// sql执行失败
			$this->error=$this->getError();
			return false;
		}
		if(!($result instanceof \mysqli_result)){
			$this->error=L()->def('MysqliProcessDb_mysqli_result','query只用于SELECT/SHOW/DESCRIBE/EXPLAIN查询SQL语句');
			return false;
		}
		// 查询结果集中的行数,来自select返回的$result对象
		$num_rows=mysqli_num_rows($result);
		$this->numRows=$num_rows;
		$list=array();
		// 如果有数据则返回 fetch_assoc|以关联数组返回
		if($num_rows>0){
			for($i=0;$i<$num_rows;$i++){
				$list[$i]=mysqli_fetch_assoc($result);
			}
		}
		return $list;
	}
	/**
	 * 执行sql，返回执行结果
	 * 只有 select查询等mysqli才会返回result对象
	 * 
	 * @return false|array
	 */
	public function execute($sql,array $params=[]){
		if($params){
			throw new \Exception('数据库驱动'.__METHOD__.'不支持预处理');
		}
		$mysqli	=$this->getConn();
		$result =mysqli_query($mysqli,$sql);
		if($result===false){
			// sql执行失败
			$this->error=$this->getError();
			return false;
		}
		return true;
	}
	/**
	 * 释放查询结果
	 * $r=new \mysqli_result();
	 */
	public function free(){
		if($this->result!==null){
			mysqli_free_result($this->result);
		}
		$this->result=null;
	}
    /**
     * 关闭数据库链接
     * 
     * @see \qing\db\Connection :: close
     */
	public function close(){
		if($this->conn && $this->autoClose){
			mysqli_close($this->conn);
		}
	}
	/**
	 * 规定 MySQL 连接;如果未规定，则使用上一个连接。
	 * 
	 * @see \qing\db\Connection::getInsertId()
	 */
	public function getInsertId(){
		return mysqli_insert_id($this->conn);
	}
	/**
	 * 获取数据执行错误
	 */
	public function getError(){
		$this->error=mysqli_errno($this->conn).':'.mysqli_error($this->conn);
		return $this->error;
	}
	//[事务操作|注意只有InnoDb支持事务|MyISAM这些方法不起作用]
	/**
	 * 是否自动提交
	 *
	 * @param bool $mode
	 */
	public function autocommit($mode){
		return mysqli_autocommit($this->getConn(),$mode);
	}
	/**
	 * 事务处理|开始事务
	 * 
	 * @see \qing\db\Connection::begin()
	 */
	public function begin(){
		return mysqli_begin_transaction($this->getConn());
	}
	/**
	 * 提交事务
	 * 
	 * @see \qing\db\Connection::commit()
	 */
	public function commit(){
		$res=mysqli_commit($this->getConn());
		if($res===false){
			$this->getError();
			return false;
		}
		return $res;
	}
	/**
	 * 事务回归
	 * 
	 * @see \qing\db\Connection::rollback()
	 */
	public function rollback(){
		$res=mysqli_rollback($this->getConn());
		if($res===false){
			$this->getError();
			return false;
		}
		return $res;
	}
}
?>
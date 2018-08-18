<?php
namespace qing\db\mysql;
use qing\db\Connection;
/**
 * Mysqli 数据库驱动/数据库访问对象
 * 
 * 打印$mysqli，可以看到那些暴露的属性
 * 
 * @property \mysqli $conn
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MysqliConnection extends Connection{
	/**
	 * 数据库版本
	 * 
	 * @var string
	 */
	public $version;
	/**
	 * @var \mysqli_result
	 */
	protected $result;
	/**
	 * 创建数据库连接
	 */
	public function connect(){
		try{
			$mysqli=@new \mysqli($this->host,$this->user,$this->pwd,$this->name,$this->port);
			//链接错误标识不为0，抛出错误
			if($mysqli->connect_errno>0){
				throw new \Exception('Db::Mysqli Connect Error: '.iconv('GB2312','UTF-8',$mysqli->connect_error));
			}
		}catch(\Exception $e){
			throw $e;
		}
		//数据库版本
		$this->version=$mysqli->server_info; 
		//设置数据库编码
		$mysqli->set_charset($this->charset);
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
			throw new \Exception('mysqli数据库驱动'.__METHOD__.'不支持预处理');
		}
		$mysqli=$this->getConn();
		$result=$this->result=$mysqli->query($sql);
		if($result===false){
			// sql执行失败
			// $mysqli->error === mysqli_error($mysqli)/只是面向过程的写法
			$this->error=$this->getError();
			return false;
		}
		if(!($result instanceof \mysqli_result)){
			$this->error='query只用于SELECT/SHOW/DESCRIBE/EXPLAIN查询SQL语句';
			return false;
		}
		//MYSQLI_ASSOC|MYSQLI_NUM
		$list=$result->fetch_all(MYSQLI_ASSOC);
		return $list;
	}
	/**
	 * 执行sql，返回执行结果
	 * 只有 select查询等mysqli才会返回result对象
	 * 
	 * @see \qing\db\Connection::execute()
	 * @return false|true
	 */
	public function execute($sql,array $params=[]){
		if($params){
			throw new \Exception('mysqli数据库驱动'.__METHOD__.'不支持预处理');
		}
		$mysqli=$this->getConn();
		//$result=true/false
	    $result=$this->result=$mysqli->query($sql);
		if($result===false){
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
		if($this->result){
			$this->result->free_result();
		}
		$this->result=null;
	}
    /**
     * 关闭数据库链接
     * 
     * @see \qing\db\Connection :: close
     */
	public function close(){
		$this->free();
		if($this->conn){
			$this->conn->close();
		}
	}
	/**
	 * insert into 后的主键
	 * 设置插入记录的主键ID
	 * ---
	 * - 插入数据后返回id;
	 * - 来自类 mysqli[注意，当表中没有主键时，返回0]
	 * 注意：当表没有主键时,会返回null,如果上一查询没有产生 AUTO_INCREMENT 的值，则 mysql_insert_id() 返回 0。
	 * 
	 */
	public function getInsertId(){
		return $this->conn->insert_id;
	}
	/**
	 * #select查询到的行数
	 * mysqli:mysqli_num_rows()
	 * 
	 * - select查询结果集的行数;
	 * - 来自类 mysqli_result, mysqli
	 * - query后返回mysqli_result对象
	 * 
	 * @return number
	 */
	public function getNumRows(){
		return $this->result->num_rows;
	}
	/**
	 * - 影响的行数;
	 * - insert,update,delete|插入更新或者删除影响的行数
	 * - 来自类 mysqli
	 * 
	 * #INSERT/UPDATE/REPLACE/DELETE影响到的行数
	 * mysqli:mysqli_affected_rows()
	 * insert,update,delete影响的行数   +来自类 mysqli
	 * 
	 * @return number
	 */
	public function getAffectedRows(){
		return $this->conn->affected_rows;
	}
	/**
	 * - 影响的字段/不是行数
	 * - 类 mysqli mysqli_result 均存在
	 * 
	 * @return number
	 */
	public function getFieldCount(){
		return $this->conn->field_count;
	}
	/**
	 * 获取数据执行错误
	 */
	public function getError(){
		$this->error=$this->conn->errno.':'.$this->conn->error;
		return $this->error;
	}
	//[事务操作|注意只有InnoDb支持事务|MyISAM这些方法不起作用]
	/**
	 * 是否自动提交
	 *
	 * @param bool $mode true|false
	 */
	public function autocommit($mode){
		return $this->getConn()->autocommit($mode);
	}
	/**
	 * 事务处理|开始事务
	 * 
	 * @see \qing\db\Connection::begin()
	 */
	public function begin(){
		return $this->getConn()->begin_transaction();
	}
	/**
	 * 提交事务
	 * 
	 * @see \qing\db\Connection::commit()
	 */
	public function commit(){
		$res=$this->getConn()->commit();
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
		$res=$this->getConn()->rollback();
		if($res===false){
			$this->getError();
			return false;
		}
		return $res;
	}
}
?>
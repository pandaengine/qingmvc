<?php
namespace qing\db\mysql;
use qing\db\Connection;
/**
 * Mysqli 数据库驱动/数据库访问对象
 *
 * ---
 * mysql_affected_rows — 取得前一次 MySQL 操作所影响的记录行数
 * 
 * Warning
 * 本扩展自 PHP 5.5.0 起已废弃，并在将来会被移除。
 * 应使用 MySQLi 或 PDO_MySQL 扩展来替换之。
 * 参见 MySQL：选择 API 指南以及相关 FAQ 以获取更多信息。
 * 用以替代本函数的有：
 * 
 * - mysqli_affected_rows()
 * - PDOStatement::rowCount()
 * ---
 *
 * @deprecated php7已废弃
 * mysql_connect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MysqlConnection extends Connection{
	/**
	 * 数据库版本
	 * 
	 * @var string
	 */
	public $version;
	/**
	 * 当前查询结果集
	 *
	 * @var object
	 */
	protected $result;
	/**
	 * 链接对象|该重写属性只是为了zendstudio提示
	 * 
	 * @var \mysql
	 */
	// protected $connection;
	/**
	 * 创建数据库连接
	 */
	public function connect(){
		// localhost:3306
		if($this->port){
			$server=$this->host.':'.$this->port;
		}else{
			$server=$this->host;
		}
		// mysql_connect() 函数打开非持久的 MySQL 连接。
		$link=@mysql_connect($server,$this->user,$this->pwd);
		// 长链接 mysql_pconnect() 函数打开一个到 MySQL 服务器的持久连接。
		// $link=mysql_pconnect($server,$config->user,$config->pwd);
			
		// 规定 SQL 连接标识符。如果未规定，则使用上一个打开的连接。
		if($link===false || mysql_errno()>0){
			throw new \Exception('Db::Mysql Connect Error: '.iconv('GB2312','UTF-8',mysql_error()));
		}
		// 选择数据库
		mysql_select_db($this->name,$link);
		// 数据库版本
		$this->version=mysql_get_server_info($link);
		// 设置数据库编码
		mysql_set_charset($this->charset,$link);
		return $link;
	}
	/**
	 * 执行查询，返回数据
	 * ---
	 * 
	 * @uses \mysqli ::query()
	 * false on failure.
	 * For successful SELECT, SHOW, DESCRIBE or EXPLAIN queries mysqli_query will return a mysqli_result object.
	 * For other successful queries mysqli_query will return true.
	 * ---
	 * @see \qing\db\Connection ::query()
	 * @uses \mysqli_result
	 * @return array
	 */
	public function query($sql,array $params=[]){
		if($params){
			throw new \Exception('mysql数据库驱动'.__METHOD__.'不支持预处理');
		}
		$mysql=$this->getConn();
		// sql语句 | 查询字符串不应以分号结束
		// $mysql | 规定 SQL 连接标识符。如果未规定，则使用上一个打开的连接。
		$result=$this->result=mysql_query($sql,$mysql);
		if($result===false){
			// sql执行失败
			$this->error=mysql_error($mysql);
			return false;
		}
		// 查询结果集中的行数
		$num_rows=mysql_num_rows($result);
		$this->numRows=$num_rows;
		$list=array();
		// 如果有数据则返回 fetch_assoc|以关联数组返回
		if($num_rows>0){
			for($i=0;$i<$num_rows;$i++){
				$list[$i]=mysql_fetch_assoc($result);
			}
		}
		return $list;
	}
	/**
	 * 执行sql，返回执行结果
	 * 只有 select查询等mysqli才会返回result对象
	 *
	 * @return false array
	 */
	public function execute($sql,array $params=[]){
		if(!$params){
			throw new \Exception('mysql数据库驱动'.__METHOD__.'不支持预处理');
		}
		$mysql=$this->getConn();
		// sql语句 | 查询字符串不应以分号结束
		// $mysql | 规定 SQL 连接标识符。如果未规定，则使用上一个打开的连接。
		$result=$this->result=mysql_query($sql,$mysql);
		if($result===false){
			// sql执行失败
			$this->error=mysql_error($mysql);
			return false;
		}
		return true;
	}
	/**
	 * 释放查询结果
	 */
	public function free(){
		//$result结果集
		mysql_free_result($this->result);
		$this->result=null;
	}
	/**
	 * 关闭数据库链接
	 * @see \qing\db\Connection :: close
	 */
	public function close(){
		if($this->conn && $this->autoClose){
			mysql_close($this->conn);
		}
	}
	
	//--------------------------------------------------------
	
	/**
	 * 插入记录的主键ID
	 * @see \qing\db\Connection::getInsertId()
	 */
	public function getInsertId(){
		return mysql_insert_id($this->conn);
	}
	/*
	public function getNumRows(){
		return mysql_num_rows($this->result);
	}
	*/
	/**
	 * 取得最近一次与 link_identifier 关联的 INSERT，UPDATE 或 DELETE 查询所影响的记录行数。
	 * 
	 * @see \qing\db\Connection :: close
	 */
	public function getAffectedRows(){
		return mysql_affected_rows($this->conn);
	}
	/**
	 * 获取数据执行错误
	 */
	public function getError(){
		$this->error=mysql_errno().':'.mysql_error();
		return $this->error;
	}
	
	//[事务操作|注意只有InnoDb支持事务|MyISAM这些方法不起作用]---
	
	/**
	 * 是否自动提交
	 *
	 * @param bool $mode
	 */
	public function autocommit($mode){
		$mode=$mode?1:0;
		return mysql_query('SET AUTOCOMMIT='.$mode,$this->getConn());
	}
	/**
	 * 事务处理|开始事务
	 * 
	 * @see \qing\db\Connection::begin()
	 */
	public function begin(){
		return mysql_query('START TRANSACTION',$this->getConn());
	}
	/**
	 * 提交事务
	 * @see \qing\db\Connection::commit()
	 */
	public function commit(){
		$res=mysql_query('COMMIT',$this->getConn());
		if($res===false){
			$this->getError();
			return false;
		}
		return $res;
	}
	/**
	 * 事务回归
	 * @see \qing\db\Connection::rollback()
	 */
	public function rollback(){
		$res=mysql_query('ROLLBACK',$this->getConn());
		if($res===false){
			$this->getError();
			return false;
		}
		return $res;
	}
}
?>
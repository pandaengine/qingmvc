<?php
namespace qing\db\sqlite;
use qing\db\Connection;
/**
 * Sqlite 数据库驱动/数据库访问对象
 *
 * 一般指Sqlite2,Sqlite3请使用Sqlite3Db驱动
 *
 * @deprecated 使用Pdo代替
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SqliteConnection extends Connection{
	/**
	 * 创建数据库连接
	 */
	public function connect(){
		$sqlite_error='';
		//$config->name|sqlite文件路径
		$sqlite=sqlite_open($config->name,0666,$sqlite_error);
		if(!$sqlite){
			throw new \Exception('Db::Sqlite Connect Error: '.$sqlite_error);
		}
		return $sqlite;
	}
	/**
	 * 执行查询，返回数据
	 * 
	 * @see \qing\db\Connection ::query()
	 */
	public function query($sql,array $bindings=[]){
		$sqlite=$this->getConn();
		$result=sqlite_query($sqlite,$sql);
		if(!$result){
			$this->setError();
			return false;
		}
		$num_rows=sqlite_num_rows($result);
		$this->num_rows=$num_rows;
		$res=array();
		// 如果有数据则返回 fetch_assoc 以关联数组返回
		if($num_rows>0){
			for($i=0;$i<$num_rows;$i++){
				$res[$i]=sqlite_fetch_array($result,SQLITE_ASSOC);
			}
		}
		return $res;
	}
	/**
	 * 执行sql，返回执行结果
	 * 
	 * @see \qing\db\Connection ::execute()
	 */
	public function execute($sql,array $bindings=[]){
		$sqlite=$this->getConn();
		$result=sqlite_exec($sqlite,$sql);
		if(!$result){
			return false;
		}
		return true;
	}
	/**
	 * 关闭数据库链接
	 * 
	 * @see \qing\db\Connection::close()
	 */
	public function close(){
		if($this->conn && $this->autoClose){
			sqlite_close($this->conn);
		}
	}
	/**
	 * @see \qing\db\Connection::autocommit()
	 */
	public function autocommit($mode){
	}
	/**
	 * 事务开始
	 * 
	 * @see \qing\db\Connection ::begin()
	 */
	public function begin($sql){
		return sqlite_query($this->conn,'BEGIN TRANSACTION');
	}
	/**
	 * 事务提交
	 * 
	 * @see \qing\db\Connection ::commit()
	 */
	public function commit($sql){
		return sqlite_query($this->conn,'COMMIT TRANSACTION');
	}
	/**
	 * 事务回滚
	 * 
	 * @see \qing\db\Connection::rollback()
	 */
	public function rollback($sql){
		return sqlite_query($this->conn,'ROLLBACK TRANSACTION');
	}
	/**
	 * sqlite错误
	 */
	protected function getError(){
		$code=sqlite_last_error($this->conn);
		return $code.':'.sqlite_error_string($code);
	}
	/**
	 * 设置插入记录的主键ID
	 *
	 * @return number
	 */
	public function getInsertId(){
		return sqlite_last_insert_rowid($this->conn);
	}
	/**
	 * @return number
	 */
	public function getAffectedRows(){
		return sqlite_changes($this->conn);
	}
}
?>
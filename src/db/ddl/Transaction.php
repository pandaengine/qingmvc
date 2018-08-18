<?php
namespace qing\db\ddl;
/**
 * 四种事务隔离级别设置
 * Transaction Isolation
 * 
 * @see X:\@git\mysql_test\transaction.acid.Isolation
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Transaction{
	/**
	 * 未提交读(Read uncommitted)
	 * 
	 * @var string
	 */
	const READ_UNCOMMITTED='READ-UNCOMMITTED';
	/**
	 * 已提交读(Read committed)	
	 * 
	 * @var string
	 */
	const READ_COMMITTED='READ-COMMITTED';
	/**
	 * 可重复读(Repeatable read)
	 * 
	 * @var string
	 */
	const REPEATABLE_READ='REPEATABLE-READ';
	/**
	 * 可串行化(Serializable)	
	 * 
	 * @var string
	 */
	const SERIALIZABLE = 'SERIALIZABLE';
	/**
	 * 获取事务隔离基本
	 * 
	 * SELECT @@GLOBAL.tx_isolation, @@tx_isolation;
	 * SELECT @@GLOBAL.tx_isolation,@@session.tx_isolation,@@tx_isolation;
	 * select @@session.tx_isolation;
	 * select @@tx_isolation;
	 * select @@global.tx_isolation;
	 * 
	 * show VARIABLES like '%tx%'
	 * 
	 * @return string
	 */
	public static function getIsolation($global=false){
		if($global){
			return 'select @@global.tx_isolation';
		}else{
			return 'select @@session.tx_isolation';
		}
	}
	/**
	 * 设置事务隔离基本
	 * 当前连接有效?
	 * 
	 * # 需要连接符
	 * set tx_isolation='READ-UNCOMMITTED';
	 * set tx_isolation='REPEATABLE-READ';
	 * 
	 * # 不能用连接符
	 * SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ
	 * 
	 * @return string
	 */
	public static function setIsolation($level,$global=false){
		//return "set tx_isolation='{$level}' ";
		$level=str_replace('-',' ',$level);
		if($global){
			return 'SET GLOBAL TRANSACTION ISOLATION LEVEL '.$level;
		}else{
			return 'SET SESSION TRANSACTION ISOLATION LEVEL '.$level;
		}
	}
	/**
	 * 事务等待锁的超时秒数
	 * show VARIABLES like '%innodb_lock_wait_timeout%';
	 * SELECT @@global.innodb_lock_wait_timeout,@@session.innodb_lock_wait_timeout,@@innodb_lock_wait_timeout;
	 *
	 * @param string $global
	 * @return string
	 */
	public static function get_innodb_lock_wait_timeout($global=false){
		if($global){
			return 'SELECT @@global.innodb_lock_wait_timeout';
		}else{
			return 'SELECT @@session.innodb_lock_wait_timeout';
		}
	}
	/**
	 * 事务等待锁的超时秒数
	 * set @@session.innodb_lock_wait_timeout=10;
	 * 
	 * @param number $time
	 * @param string $global
	 * @return string
	 */
	public static function set_innodb_lock_wait_timeout($time,$global=false){
	if($global){
			return 'set @@global.innodb_lock_wait_timeout='.$time;
		}else{
			return 'set @@session.innodb_lock_wait_timeout='.$time;
		}
	}
	/**
	 * select @@autocommit
	 * SELECT @@global.autocommit,@@session.autocommit,@@autocommit;
	 * 
	 * @return string
	 */
	public static function getAutocommit(){
		return "select @@session.autocommit";
	}
}
?>
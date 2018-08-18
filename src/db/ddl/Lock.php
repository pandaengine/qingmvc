<?php
namespace qing\db\ddl;
/**
 * 数据库锁
 * 
 * - 读锁-写锁
 * - 行锁-表锁
 * - 显式读锁表锁
 * SHOW FULL PROCESSLIST
 * show status like '%lock%'
 * show status like '%table%'
 * show VARIABLES like '%lock%';
 * show VARIABLES like '%table%';
 * show VARIABLES like '%wait%';
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Lock{
	/**
	 * 读取数据并申请一个读锁，排它锁；
	 * - innodb: 可能是表锁或行锁
	 * - myisam: 总是表锁
	 * 
	 * SELECT * FROM pre_tests WHERE id=1 FOR UPDATE;
	 * - 允许：非锁定读select?快照读?
	 * - 不允许：共享读select...share mode
	 * - 不允许: 写，update,delete
	 * - 不允许: 排它锁读
	 * 
	 * @param string $sql
	 * @return string
	 */
	public static function for_update($sql=''){
		return $sql.' FOR UPDATE';
	}
	/**
	 * 读取数据并申请一个读锁，共享锁；
	 * - 允许：非锁定读select
	 * - 允许：共享读select...share mode
	 * - 不允许: 写，update,delete
	 * - 不允许: 排它锁读
	 * - 间隙/行锁: insert? 
	 * 
	 * SELECT * FROM pre_tests WHERE id=1 LOCK IN SHARE MODE;
	 *
	 * @param string $sql
	 * @return string
	 */
	public static function lock_in_share_mode($sql=''){
		return $sql.' LOCK IN SHARE MODE';
	}
	/**
	 * 申请一个表锁
	 * - local在innodb中无效
	 * - myisam非事务引擎也是支持的
	 * 
	 * LOCK TABLES pre_tests WRITE, t2 WRITE; 
	 * LOCK TABLES pre_tests READ LOCAL;
	 *
	 * @param string $table
	 * @return string
	 */
	public static function lock_table_read($table){
		return "LOCK TABLES {$table} READ";
	}
	public static function lock_table_write($table){
		return "LOCK TABLES {$table} WRITE";
	}
	/**
	 * 解除当前连接的所有表锁
	 *
	 * @return string
	 */
	public static function unlock_tables(){
		return 'UNLOCK TABLES';
	}
}
?>
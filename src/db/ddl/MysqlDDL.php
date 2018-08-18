<?php
namespace qing\db\ddl;
/**
 * Mysql DDL语句
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MysqlDDL extends DDL{
	/**
	 * 修复自增序列
	 * 取得主键的最大值
	 * 
	 * @see \qing\db\ddl\DDL::fixIncrement()
	 */
	public static function fixIncrement($table,$primaryKey='id'){
		return " SELECT MAX(`{$primaryKey}`) as value FROM {$table} ";
	}
	/**
	 * 重置自增序列
	 * 
	 * @see \qing\db\ddl\DDL::resetIncrement()
	 */
	public static function resetIncrement($table,$value=1){
		$value=(int)$value;
		return "ALTER TABLE {$table} AUTO_INCREMENT={$value} ";
	}
	/**
	 * 打开或关闭完整性检查|Integrity=完整性
	 * 
	 * @see \qing\db\ddl\DDL::checkIntegrity()
	 */
	public static function checkIntegrity($check=true){
		return 'SET FOREIGN_KEY_CHECKS='.($check?1:0);
	}
	/**
	 * 获取表字段列的数据
	 * 
	 * SHOW COLUMNS FROM pre_session
	 * SHOW FULL COLUMNS FROM pre_session
	 * 
	 * select * from information_schema.tables where table_name="pre_note";
	 * 
	 * @see \qing\db\ddl\DDL::showColumns()
	 */
	public static function showColumns($table){
		return 'SHOW FULL COLUMNS FROM '.$table;
	}
	/**
	 * 返回当前数据库的所有表名
	 * 
	 * @see \qing\db\ddl\DDL::allTableNames()
	 */
	public static function allTableNames($database=''){
		if($database==''){
			$sql='SHOW TABLES';
		}else{
			$sql='SHOW TABLES FROM '.$database;
		}
		return $sql;
	}
	/**
	 * 返回创建表的代码
	 * 
	 * @see \qing\db\ddl\DDL::showCreateTable()
	 */
	public static function showCreateTable($table){
		return 'SHOW CREATE TABLE '.$table;
	}
	/**
	 * 更多信息
	 * select * from information_schema.`PROCESSLIST`
	 * 
	 * @see \qing\db\ddl\DDL::showProcesslist()
	 */
	public static function showProcesslist(){
		return 'SHOW FULL PROCESSLIST';
	}
	/**
	 * @see \qing\db\ddl\DDL::killProcess()
	 */
	public static function killProcess($id){
		return 'KILL '.$id;
	}
}
?>
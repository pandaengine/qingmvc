<?php
namespace qing\db\ddl;
/**
 * - 数据库模式定义语言DDL(Data Definition Language)
 * - 和sql语句不同
 * 
 * CREATE TABLE
 * ALTER TABLE
 * TRUNCATE TABLE
 * CREATE INDEX
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class DDL{
	/**
	 * DROP DATABASE 语句用于删除数据库：DROP DATABASE 数据库名称
	 * http://www.w3school.com.cn/sql/sql_drop.asp
	 *
	 * @param string $database
	 * @return string
	 */
	public static function dropDatabase($database){
		return "DROP DATABASE {$database} ";
	}
	/**
	 * 修改表名
	 * 
	 * @param string $table
	 * @param string $newName
	 * @return string
	 */
	public static function renameTable($table,$newName){
		return "RENAME TABLE {$table} TO {$newName} ";
	}
	/**
	 * 删除表（表的结构、属性以及索引也会被删除）
	 * http://www.w3school.com.cn/sql/sql_drop.asp
	 * 
	 * @param string $table
	 * @return string
	 */
	public static function dropTable($table){
		return "DROP TABLE {$table} ";
	}
	/**
	 * 截断表，快速清空表，速度比delete速度快
	 * 仅仅需要除去表内的数据，但并不删除表本身
	 * 
	 * @param string $table 表名
	 * @return string
	 */
	public static function truncateTable($table){
		return "TRUNCATE TABLE {$table} ";
	}
	/**
	 * 添加一个列
	 * 
	 * ALTER TABLE table_name ADD column_name datatype
	 * http://www.w3school.com.cn/sql/sql_alter.asp
	 * @param string $table
	 * @param string $column
	 * @param string $type
	 * @return string
	 */
	public static function addColumn($table,$column,$type){
		return "ALTER TABLE {$table} ADD {$column} {$type} ";
	}
	/**
	 * 删除某个列/字段
	 * ALTER TABLE table_name DROP COLUMN column_name
	 * http://www.w3school.com.cn/sql/sql_alter.asp
	 * 
	 * @param string $table  表
	 * @param string $column 指定列
	 * @return string
	 */
	public static function dropColumn($table,$column){
		return "ALTER TABLE {$table} DROP COLUMN {$column} ";
	}
	/**
	 * 重命名一个列/字段
	 * http://www.w3school.com.cn/sql/sql_alter.asp
	 * 
	 * @param string $table
	 * @param string $name
	 * @param string $newName
	 * @return string
	 */
	public static function renameColumn($table,$name,$newName){
		return "ALTER TABLE {$table} RENAME COLUMN {$name} TO {$newName} ";
	}
	/**
	 * 移除外键约束
	 * http://www.w3school.com.cn/sql/sql_foreignkey.asp
	 * 
	 * @param string $name  键名
	 * @param string $table 表名
	 * @return string
	 */
	public static function dropForeignKey($name,$table){
		return "ALTER TABLE {$table} DROP FOREIGN KEY {$name} ";
	}
	/**
	 * 创建索引的sql语句
	 * 
	 * UNIQUE KEY `idx_category_keyword` (`category`,`keyword`) USING BTREE
	 * ---
	 * @param string $name    索引名称
	 * @param string $table   表名
	 * @param string $column  列名/字段名
	 * @param string $unique  是否是唯一索引
	 * @return string
	 */
	public static function createIndex($name,$table,$column,$unique=false){
		if(is_array($column)){
			$column=implode(',',$column);
		}
		if($unique){
			return "CREATE UNIQUE INDEX {$name} ON {$table} ({$column}) ";
		}else{
			return "CREATE INDEX {$name} ON {$table} ({$column}) ";
		}
	}
	/**
	 * 添加唯一索引
	 *
	 * @param string $name  索引名称
	 * @param string $table 索引所在的表
	 * @return string
	 */
	public static function createUniqueIndex($name,$table){
		return $this->createIndex($name, $table, true);
	}
	/**
	 * 移除索引
	 * ALTER TABLE table_name DROP INDEX index_name
	 * http://www.w3school.com.cn/sql/sql_drop.asp
	 * 
	 * @param string $name  索引名称
	 * @param string $table 索引所在的表
	 * @return string
	 */
	public static function dropIndex($name,$table){
		return "DROP INDEX {$name} ON {$table} ";
	}
	/**
	 * 添加主键|addPrimaryKey|addPk
	 * 
	 * http://www.w3school.com.cn/sql/sql_primarykey.asp
	 * ALTER TABLE Persons ADD PRIMARY KEY (Id_P)
	 * ALTER TABLE Persons ADD CONSTRAINT pk_PersonID PRIMARY KEY (Id_P,LastName)
	 * 
	 * @param string $table 表名
	 * @param string $field 字段  
	 * @return string
	 */
	public static function addPrimaryKey($table,$field){
		return "ALTER TABLE {$table} ADD PRIMARY KEY {$field} ";
	}
	/**
	 * 移除主键
	 * 
	 * @param string $table
	 * @return string
	 */
	public static function dropPrimaryKey($table){
		return "ALTER TABLE {$table} DROP PRIMARY KEY ";
	}
	/**
	 * 复位序列|设置主键值|数据丢失的时候，设置主键值，防止后添加数据覆盖丢失数据的主键
	 * ---
	 * - 重置一个表的主键值的序列
	 * - 序列将被重置，主键的下一行插入
	 * - 将指定的值或主键和一个最大值（即序列微调）
	 * ---
	 * 
	 * @param string $table 表名
	 * @param string $value 重置的值
	 */
	public static function fixIncrement($table,$value=null){
		throw new \Exception('驱动不支持：'.__METHOD__);
	}
	/**
	 * 重置自增序列
	 * 
	 * @param string $table
	 * @param number $value
	 * @throws \Exception
	 */
	public static function resetIncrement($table,$value=1){
		throw new \Exception('驱动不支持：'.__METHOD__);
	}
	/**
	 * 打开或关闭完整性检查
	 * Integrity=完整性
	 *
	 * @param boolean $check
	 */
	public static function checkIntegrity($check=true){
		throw new \Exception('驱动不支持：'.__METHOD__);
	}
	/**
	 * 返回当前数据库的所有表名
	 * 
	 * @param string $database 指定的数据库名
	 * @throws \Exception
	 */
	public static function allTableNames($database=''){
		throw new \Exception('驱动不支持：'.__METHOD__);
	}
	/**
	 * 返回创建表的代码
	 * 
	 * @param string $table
	 * @throws \Exception
	 */
	public static function showCreateTable($table){
		throw new \Exception('驱动不支持：'.__METHOD__);
	}
	/**
	 * 显示某个表的列/字段信息
	 *
	 * @param string $table
	 * @throws \Exception
	 */
	public static function showColumns($table){
		throw new \Exception('驱动不支持：'.__METHOD__);
	}
	/**
	 * @throws \Exception
	 */
	public static function showProcesslist(){
		throw new \Exception('驱动不支持：'.__METHOD__);
	}
	/**
	 * @throws \Exception
	 */
	public static function killProcess($id){
		throw new \Exception('驱动不支持：'.__METHOD__);
	}
}
?>
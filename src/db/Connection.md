
```
/**
 * 插入数据后返回id
 * 
 * @var int
 */
protected $insertId=0;
/**
 * select:查询到结果集行数/直接统计返回的结果集即可
 * 
 * #select查询到的行数
 * #只用于select操作|此命令仅对 SELECT 语句有效。
 * mysql_num_rows—取得结果集中行的数目
 * mysql_num_rows() 返回结果集中行的数目。
 * 要取得被 INSERT，UPDATE 或者 DELETE 查询所影响到的行的数目，用 mysql_affected_rows()。
 * ---
 * mysql:mysql_num_rows();
 * mysqli:mysqli_num_rows()
 * pdo:PDOStatement::rowCount()
 * count(list)
 *
 * @var int
 */
protected $numRows=0;
/**
 * update/insert/delete:影响到的行数
 * 
 * #delete/update影响到的行数
 * #取得 INSERT，UPDATE 或 DELETE 查询所影响的记录行数。
 * #相关操作：INSERT/UPDATE/REPLACE/DELETE
 * ---
 * mysql:mysql_affected_rows();
 * mysqli:mysqli_affected_rows()
 * pdo:PDOStatement::rowCount()
 * 
 * @var int
 */
protected $affectedRows=0;
/**
 * 释放查询结果
 * - mysql_free_result()
 * - 仅需要在考虑到返回很大的结果集时会占用多少内存时调用。
 * - 如果不掉用该函数，在脚本结束后所有关联的内存都会被自动释放。
 */
protected function free(){
}
```

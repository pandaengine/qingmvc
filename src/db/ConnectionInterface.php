<?php 
namespace qing\db;
/**
 * 数据库连接接口
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface ConnectionInterface{
	/**
	 * 连接数据库
	 * 
	 * @name open
	 */
	public function connect();
	/**
	 * 关闭数据库 链接
	 */
	public function close();
	/**
	 * 查询SQL,查询数据并返回数据
	 *
	 * @param string $sql      sql语句
	 * @param array  $bindings 绑定的预处理参数
	 * @return array
	*/
	public function query($sql,array $bindings=[]);
	/**
	 * 执行SQL，返回执行结果
	 * fe: update,delete,replace,insert,ddl
	 *
	 * @param string $sql	   sql语句
	 * @param array  $bindings 绑定的预处理参数
	 * @return bool
	*/
	public function execute($sql,array $bindings=[]);
	
	//[事务]---
	
	/**
	 * 是否自动提交
	 * SET AUTOCOMMIT = {0 | 1}
	 * 
	 * @deprecated
	 * @param bool $mode
	 * @return bool
	*/
	public function autocommit($mode);
	/**
	 * 开始事务
	 * 
	 * - 标准: START TRANSACTION
	 * - 别名: BEGIN [WORK]
	 * - 当作一天普通sql执行也可以
	 * 	$res=Model::execute('START TRANSACTION');
	 * 
	 * @return bool
	 */
	public function begin();
	/**
	 * 提交事务
	 * COMMIT [WORK]
	 *
	 * @return bool
	*/
	public function commit();
	/**
	 * 回滚事务
	 * ROLLBACK [WORK]
	 *
	 * @return bool
	*/
	public function rollback();
	/**
	 * - 获取最后执行的sql语句
	 * - 当绑定预处理参数的时候要解析处理
	 *
	 * @return string
	 */
	public function getSql();
}
?>
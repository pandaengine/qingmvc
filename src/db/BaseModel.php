<?php
namespace qing\db;
use qing\com\Component;
use qing\cache\CacheX;
/**
 * Model 模型基类
 * 
 * @final  子类不能覆盖
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class BaseModel extends Component{
	/**
	 * 模型内部错误
	 *
	 * @var string
	 */
	protected $error='';
	/**
	 * 当前数据库操作对象|数据库链接等
	 *
	 * @var \qing\db\Connection
	 */
	protected $_conn;
	/**
	 * 数据库连接名称
	 *
	 * @var string
	 */
	protected $connName='';
	/**
	 * 缓存链接名
	 *
	 * @var string
	 */
	protected $cacheName='queryCache';
	/**
	 * @param string $conn
	 * @return $this
	 */
	public function connName($conn){
		$this->connName=$conn;
		return $this;
	}
	/**
	 * @param string $conn
	 * @return $this
	 */
	public function cacheName($conn){
		$this->cacheName=$conn;
		return $this;
	}
	/**
	 * 获取模型内部错误信息
	 *
	 * @return string
	 */
	public function getError(){
		return $this->error;
	}
	/**
	 * 设置错误信息
	 *
	 * @return string
	 */
	public function setError($error){
		$this->error=$error;
	}
	/**
	 * 获取数据库操作对象
	 *
	 * @return \qing\db\Connection
	 */
	public function getConn(){
		if($this->_conn===null){
			$this->_conn=Db::conn($this->connName);
		}
		return $this->_conn;
	}
	/**
	 * 返回sql
	 *
	 * @return string
	 */
	public function getSql(){
		return $this->getConn()->getSql();
	}
	/**
	 * 返回sql执行错误信息
	 *
	 * @return string
	 */
	public function getConnError(){
		return $this->getConn()->getError();
	}
	/**
	 * 获取最后插入记录的主键
	 *
	 * @return number
	 */
	public function getInsertId(){
		return $this->getConn()->getInsertId();
	}
	/**
	 * 获取select查询结果集行数
	 *
	 * @return number
	 */
	public function getNumRows(){
		return $this->getConn()->getNumRows();
	}
	/**
	 * 获取INSERT，UPDATE 或 DELETE 查询所影响的记录行数。
	 * - 更新行必须存在
	 * - 更新的字段至少有一个有修改
	 * - 更新字段的值如果不改变，则影响仍为0
	 *
	 * @notice 返回结果只能作为建议，不一定正确，mysqli和pdo的结果或许不同
	 * @return number
	 */
	public function getAffectedRows(){
		return $this->getConn()->getAffectedRows();
	}
	/**
	 * 执行查询SQL， 返回数据集
	 *
	 * @param  string $sql    	   原始sql语句
	 * @param  array  $bindings  绑定的SQL预处理参数
	 * @return array() 总是返回数组|剔除false
	 * @throws Exception
	 */
	public function query($sql,array $bindings=[]){
		return $this->getConn()->query($sql,$bindings);
	}
	/**
	 * 执行sql,返回执行结果
	 * 
	 * @param string $sql
	 * @param array  $bindings
	 * @return boolean true|false
	 */
	public function execute($sql,array $bindings=[]){
		return $this->getConn()->execute($sql,$bindings);
	}
	//
	//事务处理
	//事务开始以后，如果不提交或不回滚，会占用进程，直到连接断开自动回滚。事务隔离级别
	/**
	 * 自动提交
	 *
	 * @param bool $mode true|false
	 * @return bool
	 */
	public function autocommit($mode){
		return $this->getConn()->autocommit($mode);
	}
	/**
	 * 开始事务
	 *
	 * @return bool
	 */
	public function begin(){
		return $this->getConn()->begin();
	}
	/**
	 * 主动提交
	 *
	 * @return bool
	 */
	public function commit(){
		return $this->getConn()->commit();
	}
	/**
	 * 事务回滚
	 *
	 * @return bool
	 */
	public function rollback(){
		return $this->getConn()->rollback();
	}
	/**
	 * 只返回一行记录
	 *
	 * @param string $sql
	 * @param array  $bindings
	 * @return array
	 */
	public function queryRow($sql,array $bindings=[]){
		$list=(array)$this->query($sql,$bindings);
		if(APP_DEBUG && count($list)>1){
			throw (new exceptions\ModelException('结果集大于1条 [limit必须限制 limit 0,1]',$sql))->setTitle('queryRow : ');
			return;
		}
		if(!$list){
			return [];
		}else{
			//#返回第一个元素
			//return array_shift($list);
			return (array)current($list);
		}
	}
	/**
	 * 只返回一行记录中的一个字段
	 *
	 * @param string $sql
	 * @param array  $bindings
	 * @param string $field
	 * @return string
	 */
	public function queryField($sql,array $bindings=[],$field=''){
		$row=$this->queryRow($sql,$bindings);
		return isset($row[$field])?$row[$field]:null;
	}
	/**
	 * 删除表（表的结构、属性以及索引也会被删除）
	 *
	 * @param string $table
	 * @return string
	 */
	public function dropTable($table){
		return $this->execute("DROP TABLE `{$table}` ");
	}
	/**
	* 截断表，快速清空表，速度比delete速度快
	* 仅仅需要除去表内的数据，但并不删除表本身
	*
	* @param string $table 表名
	* @return string
	*/
	public function truncateTable($table){
		return $this->execute("TRUNCATE TABLE `{$table}` ");
	}
	/**
	 * # LOCK TABLES table READ
	 * - 其他线程可以读取，不可更新
	 * - 当前线程可以读取，不可更新
	 * - 都不可更新，只提供读取
	 * 
	 * - myisam等非事务引擎也是支持的
	 * - 不推荐在事务表中使用
	 * 
	 * @see \qing\db\ddl\Lock
	 * @param string $table 表名
	 * @return boolean
	 */
	public function lockTablesRead($table=''){
		return $this->execute("LOCK TABLES `{$table}` READ");
	}
	/**
	 * innodb中无效
	 * 
	 * @param string $table
	 * @return boolean
	 */
	public function lockTablesReadLocal($table=''){
		return $this->execute("LOCK TABLES `{$table}` READ LOCAL");
	}
	/**
	 * # lock tables write
	 * - 其他线程不可访问，更不可写
	 * - 当前线程可以访问，可以写
	 * - 提供当前线程写
	 *
	 * @see \qing\db\ddl\Lock
	 * @param string $table 表名
	 * @return boolean
	 */
	public function lockTablesWrite($table=''){
		return $this->execute("LOCK TABLES `{$table}` WRITE");
	}
	/**
	 * 解除当前连接的所有表锁
	 *
	 * @see \qing\db\ddl\Lock
	 * @return boolean
	 */
	public function unlockTables(){
		return $this->execute('UNLOCK TABLES');
	}
	/**
	 * 缓存查询结果
	 * 
	 * @param string $id
	 * @param \Clusore $callback
	 * @param integer $expire 有效时间（秒）|失效时间|0:则不限制过期时间
	 */
	public function cache($id,$callback,$expire=0){
		$cache=CacheX::conn($this->cacheName);
		//从缓存中获取
		$content=$cache->get($id);
		if(!$content){
			//缓存不存在
			$content=call_user_func($callback);
			//缓存结果
			$cache->set($id,$content,$expire);
		}
		return $content;
	}
}
?>
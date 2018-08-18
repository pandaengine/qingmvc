<?php
namespace qing\db\pdo;
use qing\db\Connection as BaseConnection;
use qing\db\exceptions\QueryException;
use qing\facades\Log;
use PDO;
/**
 * PDO驱动/预处理写法/提高性能
 * 
 * - 使用预处理语句只需要声明一条SQL命令，并向MySQL服务器送一次，
 * - 以后插入的记录时，只有参数发生变化即可。【一条sql多次执行的时候特别有用】
 * 
 * # 2015.07.13
 * - 问号定位占位符和命名占位符不能混合使用
 * - Invalid parameter number: mixed named and positional parameters
 * 
 * @log 所有错误信息都要做日志
 * @property \PDO $conn
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Connection extends BaseConnection{
	/**
	 * 持久化连接
	 * 
	 * 很多 web 应用程序通过使用到数据库服务的持久连接获得好处。
	 * 持久连接在脚本结束后不会被关闭，且被缓存，当另一个使用相同凭证的脚本连接请求时被重用。
	 * 持久连接缓存可以避免每次脚本需要与数据库回话时建立一个新连接的开销，从而让 web 应用程序更快。
	 *
	 * @var boolean
	 */
	public $persistent=false;
	/**
	 * 预处理对象;pdo声明对象
	 * 
	 * @var \PDOStatement
	 */
	protected $PDOStatement;
	/**
	 * PDO类型映射
	 *
	 * @var array
	 */
	protected $_bindType=array(
			'boolean' 	=> PDO::PARAM_BOOL,
			'integer' 	=> PDO::PARAM_INT,
			'string' 	=> PDO::PARAM_STR,
			'NULL' 		=> PDO::PARAM_NULL
	);
	/**
	 * 创建数据库连接
	 * 
	 * @return string
	 */
	protected function getDns(){
		$type  =$this->type;
		$host  =$this->host;
		$dbname=$this->name;
		$port  =$this->port;
		//$dsn = 'mysql:host=localhost;dbname=testdb;port=3306';
		$dsn   ="{$type}:host={$host};dbname={$dbname};port={$port}";
		return $dsn;
	}
	/**
	 * 创建数据库连接
	 */
	public function connect(){
		$params=[];
		$this->persistent && $params[\PDO::ATTR_PERSISTENT]=true;
		//
		$dsn=$this->getDns();
		try{
			$conn=new \PDO($dsn,$this->user,$this->pwd,$params);
		}catch(\PDOException $e){
			$err='Pdo Connect Error: '.iconv('GB2312','UTF-8',$e->getMessage());
			Log::error($err,['cat'=>'sql']);
			throw new QueryException($err);
		}
		//设置编码/query/exec
		$conn->exec('set names '.$this->charset);
		return $conn;
	}
	/**
	 * 执行查询，返回数据
	 * 
	 * @see \qing\db\Connection::query()
	 * @param string $sql      sql语句
	 * @param array  $bindings 绑定的预处理参数
	 * @throws 重要：不能抛出异常，需要判断是否需要回滚
	 * @return array
	 */
	public function query($sql,array $bindings=[]){
		$this->queryBefore($sql,$bindings);
		$conn=$this->getConn();
		//#准备和编译预处理语句，包括命名占位符和?占位符
		$stmt=$this->PDOStatement=$conn->prepare($sql);
		if($stmt===false){
			//执行失败
			$this->error='Pdo Parepare Error: '.$this->getError();
			Log::error($this->error,['cat'=>'sql']);
			if($this->debug) throw new QueryException($this->error);
			return false;
		}
		//#绑定预处理参数
		$this->bindValue($bindings);
		//#执行预处理语句
		$res=$stmt->execute();
		if($res===false){
			//执行失败，重要：不能抛出异常，需要判断是否需要回滚
			$this->error='Pdo Query Error: '.$this->getError();
			Log::error($this->error,['cat'=>'sql']);
			if($this->debug) throw new QueryException($this->error);
			return false;
		}
		//返回关联数据集
		$list=$stmt->fetchAll(\PDO::FETCH_ASSOC);
		//查询到结果集行数
		//$this->setNumRows(count($list));
		return $list;
	}
	/**
	 * 执行sql，返回执行结果
	 * 只有 select查询等mysqli才会返回result对象
	 * 
	 * @param string $sql      sql语句
	 * @param array  $bindings 绑定的预处理参数
	 * @throws 重要：不能抛出异常，需要判断是否需要回滚
	 * @return boolean
	 */
	public function execute($sql,array $bindings=array()){
		$this->queryBefore($sql,$bindings);
		$conn=$this->getConn();
		//准备和编译预处理语句，包括命名占位符和?占位符
		$stmt=$this->PDOStatement=$conn->prepare($sql);
		if($stmt===false){
			//执行失败
			$this->error='Pdo Prepare Error: '.$this->getError();
			Log::error($this->error,['cat'=>'sql']);
			if($this->debug) throw new QueryException($this->error);
			return false;
		}
		//#绑定预处理参数
		$this->bindValue($bindings);
		//执行预处理语句|@return false/true
		$res=$stmt->execute();
		if($res===false){
			//执行失败
			$this->error='Pdo Execute Error: '.$this->getError();
			Log::error($this->error,['cat'=>'sql']);
			if($this->debug) throw new QueryException($this->error);
			return false;
		}
		return $res;
	}
	/**
	 * 绑定预处理
	 * array_keys($values) !== range(0, sizeof($values) - 1)
	 * 
	 * # 预处理参数
	 * - PDOStatement::bindParam  — 只能绑定变量$var
	 * - PDOStatement::bindValue  — 可以绑定变量和值
	 * # 绑定结果集到变量/返回数据时
	 * - PDOStatement::bindColumn — 绑定一列到一个 PHP 变量
	 * 
	 * SELECT name,id FROM table01 WHERE name < :name AND id = :id
	 * SELECT name,id FROM table01 WHERE name < ? 	  AND id = ? 
	 * 
	 * @param array $params
	 */
	protected function bindValue(array $bindings){
		//dump($bindings);
		/*
		//#自定义索引键值|1-9|从1开始
		if(is_numeric(key($bindings)) && 0===(int)key($bindings)){
			//#参数键值从0开始则自定义参数
			$newBindings=array();
			$indexKey =1;
			//#新参数
			foreach($bindings as $value){
				$newBindings[$indexKey]=$value;
				$indexKey++;
			}
			$bindings=$newBindings;
		}
		*/
		//#准备数据;绑定占位符的对应数据
		foreach($bindings as $key=>$value){
			$dataType=$this->_getBindType($value);
			$this->PDOStatement->bindValue($key,$value,$dataType);
			/*
			if(is_array($value)){
				//1=>[$id,PDO::PARAM_INT]|:name=>[$name,PDO::PARAM_STR]
				list($realValue,$dataType)=$value;
				$this->PDOStatement->bindValue($key,$realValue,$dataType);
			}else{
				$dataType=$this->_getBindType($value);
				$this->PDOStatement->bindValue($key,$value,$dataType);
			}
			*/
		}
	}
	/**
	 * 获得绑定参数的类型
	 *
	 * @param mixed $value
	 * @return int
	 */
	protected function _getBindType($value){
		$type=gettype($value);
		if(isset($this->_bindType[$type])){
			return $this->_bindType[$type];
		}
		return PDO::PARAM_STR;
	}
	/**
	 * 释放查询结果
	 */
	public function free(){
		$this->PDOStatement=null;
	}
    /**
     * 
     * 关闭数据库链接
     * 
     * - **此连接在 PDO 对象的生存周期中保持活动。**
     * - 要想关闭连接，需要销毁对象以确保所有剩余到它的引用都被删除，可以赋一个 NULL 值给对象变量。
     * - 如果不明确地这么做，PHP 在脚本结束时会自动关闭连接。
     * 
     * - 持久化连接是否要关闭？2018.06.28
     * 
     * @see \qing\db\Connection :: close
     */
	public function close(){
		$this->free();
		if($this->conn){
			$this->conn=null;
		}
	}
	/**
	 * 插入记录的主键ID
	 * 
	 * @see \qing\db\Connection::getInsertId()
	 */
	public function getInsertId(){
		return $this->conn->lastInsertId();
	}
	/**
	 * PDOStatement::rowCount—返回受上一个 SQL 语句影响的行数
	 * PDOStatement::rowCount() 返回上一个由对应的 PDOStatement 对象执行DELETE、 INSERT、或 UPDATE 语句受影响的行数。
	 * 
	 * @bug 不能保证对所有数据有效，且对于可移植的应用不应依赖于此方式/只提供建议的值，不一定正确
	 * @deprecated
	 * @see \qing\db\Connection::getAffectedRows()
	 */
	public function getAffectedRows(){
		return $this->PDOStatement->rowCount();
	}
	/**
	 * 获取数据执行错误
	 */
	public function getError(){
		if($this->PDOStatement) {
			$errorInfo=$this->PDOStatement->errorInfo();
			$this->error=$errorInfo[1].':'.$errorInfo[2];
		}else{
			$this->error='';
		}
		return $this->error;
	}
	//[事务操作/注意只有InnoDb支持事务/MyISAM这些方法不起作用]
	/**
	 * 是否自动提交
	 *
	 * @see \qing\db\Connection::autocommit()
	 * @param bool $mode true/false
	 */
	public function autocommit($mode){
	}
	/**
	 * 事务处理|开始事务
	 * 
	 * @see \qing\db\Connection :: begin
	 */
	public function begin(){
		$res=$this->getConn()->beginTransaction();
		if($res===false){
			$this->error='Pdo beginTransaction Error: '.$this->getError();
			Log::error($this->error,['cat'=>'sql']);
			if($this->debug) throw new QueryException($this->error);
		}
		return $res;
	}
	/**
	 * 提交事务
	 * 
	 * @see \qing\db\Connection:: commit
	 */
	public function commit(){
		$res=$this->getConn()->commit();
		if($res===false){
			$this->error='Pdo commit transaction Error: '.$this->getError();
			Log::error($this->error,['cat'=>'sql']);
			if($this->debug) throw new QueryException($this->error);
		}
		return $res;
	}
	/**
	 * 回滚事务
	 * 
	 * @see \qing\db\Connection:: rollback
	 */
	public function rollback(){
		$res=$this->getConn()->rollback();
		if($res===false){
			$this->error='Pdo rollback transaction Error: '.$this->getError();
			Log::error($this->error,['cat'=>'sql']);
			throw new QueryException($this->error);//总是抛出异常
		}
		return $res;
	}
}
?>
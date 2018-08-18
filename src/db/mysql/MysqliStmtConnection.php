<?php
namespace qing\db\mysql;
use qing\db\Connection;
/**
 * Mysqli预处理写法/提高性能
 * 
 * - 使用预处理语句只需要声明一条SQL命令，并向MySQL服务器送一次，
 * - 以后插入的记录时，只有参数发生变化即可。【一条sql多次执行的时候特别有用】
 * 
 * @property \mysqli $conn
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MysqliStmtConnection extends Connection{
	/**
	 * 插入数据后返回id;+来自类 mysqli[注意，当表中没有主键时，返回0]
	 * 注意：当表没有主键时,会返回null,如果上一查询没有产生 AUTO_INCREMENT 的值，则 mysql_insert_id() 返回 0。
	 *
	 * @var int
	 */
	//public $insert_id=0;
	/**
	 * - 影响的行数;
	 * - insert,update,delete|插入更新或者删除影响的行数
	 * - 来自类 mysqli
	 * 
	 * @var int
	 */
	//public $affected_rows=0;
	/**
	 * - 影响字段;
	 * - 类 mysqli mysqli_result 均存在
	 * 
	 * @var int
	 */
	//public $field_count=0;
	/**
	 * - select查询结果集的行数;
	 * - 来自类 mysqli_result, mysqli
	 * - query后返回mysqli_result对象
	 * 
	 * @var int
	 */
	//public $num_rows=0;
	/**
	 * 数据库版本
	 * @var string
	 */
	public $version;
	/**
	 * mysqli_stmt预处理对象;mysqli_stmt声明对象
	 * 
	 * @var \mysqli_stmt
	 */
	protected $stmt;
	/**
	 * 创建数据库连接
	 */
	public function connect(){
		try{
			$mysqli=@new \mysqli($this->host,$this->user,$this->pwd,$this->name,$this->port);
			//链接错误标识不为0，抛出错误
			if($mysqli->connect_errno>0){
				throw new \Exception('Db::Mysqli Connect Error: '.iconv('GB2312','UTF-8',$mysqli->connect_error));
			}
		}catch(\Exception $e){
			throw $e;
		}
		//数据库版本
		$this->version=$mysqli->server_info; 
		//设置数据库编码
		$mysqli->set_charset($this->charset);
		return $mysqli;
	}
	/**
	 * 执行查询，返回数据
	 * ---
	 * $stmt = $mysqli->prepare("INSERT INTO CountryLanguage VALUES (?, ?, ?, ?)");
	 * $stmt->bind_param('sssd', $code, $language, $official, $percent);
	 * 
	 * - i【整型】所有INTEGER类型
	 * - d【DOUBLE】DOUBLE和FLOAT类型
	 * - s【字符串】所有其他类型（包括字符串）
	 * - b【二进制】二进制数据类型（BLOB、二进制字节串）
	 * 
	 * ---
	 * 
	 * @param string $sql    sql语句
	 * @param array  $params 绑定的预处理参数
	 * @return array
	 */
	public function query($sql,array $params=[]){
		$stmt=$this->queryInternal($sql,$params);
		if(!$stmt){
			return false;
		}
		//从预处理中获取一个结果集|只支持mysqlnd|Mysql Native Driver简称:mysqlnd|zend公司开发,避免版权问题|否则只能使用bind_result/fetch方式
		$result=$stmt->get_result();
		//结果集行数
		//$num_rows=$result->num_rows;
		//$this->numRows=$num_rows;
		//MYSQLI_ASSOC|MYSQLI_NUM
		$list=$result->fetch_all(MYSQLI_ASSOC);
		return $list;
	}
	/**
	 * 执行sql，返回执行结果
	 * 只有 select查询等mysqli才会返回result对象
	 * 
	 * @return false|array
	 */
	public function execute($sql,array $params=array()){
		$stmt=$this->queryInternal($sql,$params);
		if(!$stmt){
			return false;
		}
		return true;
	}
	/**
	 * 查询内部实现
	 *
	 * - $stmt = $mysqli->prepare("INSERT INTO table01 VALUES (?, ?, ?, ?)");
	 * - $stmt->bind_param('sssd', $code, $language, $official, $percent);
	 * -
	 * - $query="INSERT INTO pre_user(name,date) VALUES (?,?)";
	 * - $stmt = $mysqli->prepare($query);
	 * - 
	 * - 处理打算执行的SQL命令
	 * - 将2个占位符号（?）对应的参数绑定到2个PHP变量中
	 * - $stmt->bind_param('ss',$name,$date);
	 * ---
	 * - 只能绑定php变量|不能绑定值
	 * X $stmt->bind_param('ss','123','abc'); //错误不能绑定数值
	 * 
	 * @param string $sql    sql语句
	 * @param array  $params 预处理参数
	 * @throws \Exception
	 * @return mysqli_stmt
	 */
	protected function queryInternal($sql,array $params=array()){
		$mysqli=$this->getConn();
		//初始化返回stmt预处理对象
		$stmt=$this->stmt=$mysqli->stmt_init();
		//准备和编译预处理语句，包括命名占位符和?占位符
		$res =$stmt->prepare($sql);
		if($res===false){
			//执行失败
			$this->error=$this->getError();
			return false;
		}
		$this->bindParam($stmt,$params);
		//执行预处理语句
		$res=$stmt->execute();
		if($res===false){
			//执行失败
			$this->error=$this->getError();
			return false;
		}
		return $stmt;
	}
	/**
	 * 绑定参数
	 * 
	 * @param \mysqli_stmt $stmt
	 * @param array $params
	 */
	protected function bindParam($stmt,array $params){
		if($params===array()){
			return ;
		}
		//#预处理|准备数据|绑定占位符的对应数据|只支持绑定问号占位符
		//#把值包装成引用数据|$stmt->bind_param参数只能是引用
		function refValues($arr){
			// Reference is required for PHP 5.3+
			if(strnatcmp(phpversion(),'5.3')>=0){
				$refs=array();
				foreach($arr as $key=>$value){
					$refs[$key]=&$arr[$key];
				}
				return $refs;
			}
			return $arr;
		}
		//#根据参数转换成数据类型sssdib
		$params2Types=$this->params2Types($params);
		//#[ss,$id,$name]
		array_unshift($params,$params2Types);
		try{
			//#只能绑定php变量|参数是需要引用的不能绑定值
			//$stmt->bind_param('sssd', $code, $language, $official, $percent);
			call_user_func_array(array($stmt,'bind_param'),refValues($params));
		}catch (\Exception $e){
			$message='预处理语句参数绑定错误:'.$e->getMessage();
			throw new \Exception($message);
		}
	}
	/**
	 * 参数格式化成类型
	 *
	 * @param array $params
	 */
	protected function params2Types(array $params){
		$types='';
		foreach($params as $param){
			if(is_int($param)){
				//#integer
				$types.='i';
			}elseif(is_float($param)){
				//#double
				$types.='d';
			}elseif(is_string($param)){
				//#string
				$types.='s';
			}else{
				//#blob and unknown
				$types.='b';
			}
		}
		return $types;
	}
	/**
	 * 释放查询结果
	 * $r=new \mysqli_result();
	 */
	public function free(){
		if($this->stmt!==null){
			$this->stmt->free_result();
		}
		$this->stmt=null;
	}
    /**
     * 关闭数据库链接
     * 
     * @see \qing\db\Connection :: close
     */
	public function close(){
		$this->free();
		if($this->conn){
			$this->conn->close();
		}
	}
	//[事务操作|注意只有InnoDb支持事务|MyISAM这些方法不起作用]
	/**
	 * 是否自动提交
	 *
	 * @param bool $mode true|false
	 */
	public function autocommit($mode){
		return $this->getConn()->autocommit($mode);
	}
	/**
	 * 事务处理|开始事务
	 * 
	 * @see \qing\db\Connection::begin()
	 */
	public function begin(){
		return $this->getConn()->begin_transaction();
	}
	/**
	 * 提交事务
	 * 
	 * @see \qing\db\Connection::commit()
	 */
	public function commit(){
		$res=$this->getConn()->commit();
		if($res===false){
			$this->getError();
			return false;
		}
		return $res;
	}
	/**
	 * 事务回归
	 * 
	 * @see \qing\db\Connection::rollback()
	 */
	public function rollback(){
		$res=$this->getConn()->rollback();
		if($res===false){
			$this->getError();
			return false;
		}
		return $res;
	}
	/**
	 * 插入记录的主键ID
	 *
	 * @see \qing\db\Connection::getInsertId()
	 */
	public function getInsertId(){
		return $this->stmt->insert_id;
	}
	/**
	 * 获取数据执行错误
	 */
	public function getError(){
		if($this->stmt){
			$this->error=$this->stmt->errno.':'.$this->stmt->error;
		}else{
			$this->error='';
		}
		return $this->error;
	}
}
?>
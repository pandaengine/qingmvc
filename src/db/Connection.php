<?php 
namespace qing\db;
use qing\com\Component;
use qing\facades\Event;
/**
 * 数据库连接
 * 抽象类，不可被实例化
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
abstract class Connection extends Component implements ConnectionInterface{
	/**
	 * sql查询之前
	 *
	 * @var string
	 */
	const E_QUERY_BEFORE = 'sql.query.before';
	/**
	 * sql查询之后
	 *
	 * @var string
	 */
	const E_QUERY_AFTER = 'sql.query.after';
	/**
	 * 数据库类型
	 *
	 * @var string
	 */
	public $type='mysql';
	/**
	 * 数据库服务器地址
	 *
	 * @var string
	 */
	public $host='localhost';
	/**
	 * 数据库名称
	 *
	 * @var string
	 */
	public $name='test';
	/**
	 * 数据库用户名称
	 *
	 * @var string
	 */
	public $user='root';
	/**
	 * 数据库用户密码
	 *
	 * @var string
	 */
	public $pwd='root';
	/**
	 * 数据库服务器端口
	 *
	 * @var string
	 */
	public $port='3306';
	/**
	 * 数据库编码
	 *
	 * @var string
	 */
	public $charset='utf8';
	/**
	 * 数据库表前缀
	 *
	 * @deprecated
	 * @var string
	 */
	public $prefix='pre_';
	/**
	 * sql builder
	 * 默认的sql创建器的组件
	 * 对应connection连接名称
	 * 
	 * @see \qing\db\mysql\SqlBuilder
	 * @var string
	 */
	public $sqlb='sqlb@main';
	/**
	 * 开启调试
	 * - 在execute,query错误时会抛出异常
	 * - 注意：当使用事务需要错误回滚时，应该关闭
	 *
	 * @var boolean
	 */
	public $debug=true;
	/**
	 * 数据库操作对象错误信息
	 * 
	 * @var string
	 */
    protected $error="";
    /**
     * 数据库连接对象
     * conn=null关闭连接
     * 
     * @name connection
     */
    protected $conn;
    /**
     * 是否自动关闭
     * 
     * @var bool
     */
    protected $autoClose=true;
    /**
     * 最近执行的sql
     *
     * @var string
     */
    protected $_sql;
    /**
     * 预处理sql语句
     *
     * @var string
     */
    protected $_lastSql;
    /**
     * 上一次绑定的预处理参数
     *
     * @var string
     */
    protected $_lastParams;
    /**
     * 暴露给事件调用
     * 
     * @return string
     */
    public function getLastSql(){ return $this->_lastSql; }
    public function getLastParams(){ return $this->_lastParams; }
    /**
     * 析构方法
     * 
     * @access public
     */
    public function __destruct(){
    	//关闭数据库连接
    	//脚本执行结束也不关闭连接?
    	$this->autoClose && $this->close();
    }
    /**
     * 请求前事件点
     * - 执行一次请求
     * - 多次请求都使用同一个实例连接
     * - 重置信息
     * 
     * @param string $sql
     * @param array $params
     */
    protected function queryBefore($sql,array $params){
    	$this->_lastSql	  =$sql;
    	$this->_lastParams=$params;
    	$this->_sql ='';
    	$this->error='';
    	Event::trigger(self::E_QUERY_BEFORE,$this);
    }
    /**
     * 请求后事件点
     *
     * @deprecated
     */
    protected function queryAfter(){
    	Event::trigger(self::E_QUERY_AFTER,$this);
    }
    /**
     * 获取数据库连接对象
     *
     * @return object
     */
    public function conn(){
    	return $this->conn;
    }
	/**
	 * 获取数据库连接对象
	 * 懒加载/需要时才建立链接
	 *
	 * @return object
	 */
	public function getConn(){
		if(!$this->conn){
			//创建数据库链接
			$this->conn=$this->connect();
		}
		return $this->conn;
	}
	/**
	 * 是否自动提交
	 * 
	 * @param bool $mode
	 * @return bool
	 */
	public function autocommit($mode){}
	/**
	 * 关闭数据库连接
	 */
	public function close(){
		
	}
	/**
	 * 设置插入记录的主键ID
	 * 
	 * @return number
	 */
	public function getInsertId(){
		return 0;
	}
	/**
	 * #select查询到的行数
	 * 
	 * @return number
	 */
	public function getNumRows(){
		return 0;
	}
	/**
	 * @notice 返回结果只能作为建议，不一定正确，mysqli和pdo的结果或许不同
	 * @return number
	 */
	public function getAffectedRows(){
		return 0;
	}
	/**
	 * - 获取最后执行的sql语句
	 * - 当绑定预处理参数的时候要解析处理
	 *
	 * @return string
	 */
	public function getSql(){
		if(!$this->_sql){
			if($this->_lastParams){
				$this->_sql=$this->buildRealSql($this->_lastSql,$this->_lastParams);
			}else{
				$this->_sql=$this->_lastSql;
			}
		}
		return $this->_sql;
	}
	/**
	 * - SELECT name,id FROM table01 WHERE name < :name AND id = :id
	 * - SELECT name,id FROM table01 WHERE name < ? 	AND id = ?
	 * # SELECT name,id FROM table01 WHERE name < %s 	AND id = %s
	 *
	 * %s - 字符串
	 * %d - 带符号十进制数
	 * %u - 无符号十进制数
	 *
	 * @param  $sql 原始sql语句
	 * @return string
	 */
	protected function buildRealSql($sql,array $bindings){
		//#sql占位符
		$placeholder=[];
		$placeholder['?']='%s';
		foreach($bindings as $key=>$value){
			//#过滤数据
			$value=addcslashes($value,"'");
			$bindings[$key]="'{$value}'";
			if(is_numeric($key)){
				//#索引键值跳过|问号占位符
				continue;
			}else{
				//#:name/:id
				$placeholder[':'.$key]='%s';
			}
		}
		//#替换预处理符号占位符/sql语句的占位符成%s%s|SELECT name,id FROM table01 WHERE name <%s AND id = %s
		$sql=strtr($sql,$placeholder);//qreplace
		//#替换%s预处理参数
		$sql=vsprintf($sql,$bindings);//qvsprintf
		return $sql;
	}
	/**
	 * 获取数据执行错误
	 *
	 * @return string
	 */
	public function getError(){
		return $this->error;
	}
	/**
	 *
	 * @param string $error
	 * @return string
	 */
	public function setError($error){
		$this->error=$error;
	}
	/**
	 * @return string
	 */
	public function getPrefix(){
		return $this->prefix;
	}
	/**
	 *
	 * @return \qing\db\SqlBuilder
	 */
	public function getSqlBuilder(){
		return com($this->sqlb);
	}
	/**
	 * @return $this
	 */
	public function autoClose($value){
		$this->autoClose=$value;
		return $this;
	}
}
?>
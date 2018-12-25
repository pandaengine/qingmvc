<?php
namespace qing\db;
use qing\utils\ClassName;
/**
 * 链操作模型
 * 模拟sql语句的语法结构
 * 
 * 查询语句： ->table('')->fields('')->where([])->orderby('')->limit('')->select();
 * 插入语句： ->table('')->insert([]);
 * 更新语句： ->table('')->where([])->update([]);
 * 删除语句： ->table('')->where([])->delete();
 * ---
 * 查询：query 有返回数据
 * 执行：excucte 无返回数据
 *
 * @name ActiveRecord
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Model extends BaseModel{
	/**
	 * sql组成的各个部分
	 * 
	 * @var array
	 */
	protected $_parts=[];
	/**
	 * 字段
	 *
	 * @var string
	 */
	protected $fields='*';
	/**
	 * 表名前缀
	 *
	 * @var string
	 */
	protected $prefix;
	/**
	 * 数据表名（不包含表前缀）
	 *
	 * @var string
	 */
	protected $tableName;
	/**
	 * 真实数据表名（包含表前缀）
	 *
	 * @var string
	 */
	protected $realTableName;
	/**
	 * 自动获取字段
	 *
	 * @param string $fields
	 * @return $this
	 */
	public function getFields($fields=''){
		if($fields==''){
			$fields=$this->fields;
		}
		return $fields;
	}
	/**
	 * 设置表别名
	 * select count(*) as count from pre_table as t where t.fid=1
	 *
	 * @param string $alias
	 * @return $this
	 */
	public function tableAlias($alias){
		$table=$this->getTableName();
		$table=$table.' as '.$alias;
		return $this->table($table);
	}
	/**
	 * 获取表前缀;懒加载，不使用不处理
	 *
	 * @return string
	 */
	public function getPrefix(){
		if($this->prefix===null){
			$this->prefix=$this->getConn()->getPrefix();
		}
		return $this->prefix;
	}
	/**
	 * 获取表名|不包含表前缀
	 *
	 * @return string
	 */
	public function getTableName(){
		if(!$this->tableName){
			list($namespace,$modelName)=ClassName::format(rtrim(get_class($this),'Model'));
			//第一个字母小写，表名一般为小写
			$this->tableName=lcfirst($modelName);
		}
		return $this->tableName;
	}
	/**
	 * 得到完整的数据表名|包括表前缀
	 * pre_tablename
	 *
	 * @return string
	 */
	public function getRealTableName(){
		if($this->realTableName===null){
			$this->realTableName=$this->getPrefix().$this->getTableName();
		}
		return $this->realTableName;
	}
	/**
	 * - 永久性的表名
	 * - 在实例生命周期内一直存在
	 * 
	 * @param string $table
	 * @return $this
	 */
	public function tableName($table){
		$this->tableName=$table;
		return $this;
	}
	/**
	 * - 永久性的表名
	 * - 在实例生命周期内一直存在
	 *
	 * @param string $table
	 * @return $this
	 */
	public function realTableName($table){
		$this->realTableName=$table;
		return $this;
	}
	/**
	 * 取得语法器
	 *
	 * @return SqlBuilder
	 */
	public function sqlBuilder(){
		return $this->getConn()->getSqlBuilder();
	}
	/**
	 * 构建sql语句|每构建一次sql语句则需要重建/重置一次数据容器|每次数据库操作都需要重置
	 * ---
	 * 重置数据容器|语法构造器|置空 sql组装数据，以免影响下次查询 |包括表名 否则会影响下次查询|每一次数据库操作的条件都不一样必须重置
	 *
	 * @param string $action sql操作|select/insert/update
	 */
	protected function buildSql($action){
		//#表名
		if(!isset($this->_parts[SqlBuilderInterface::TABLE])){
			//#没有设置一次性表名取得默认
			//注入当前模型表名
			$this->_parts[SqlBuilderInterface::TABLE]=$this->getRealTableName();
		}
		//#生成sql
		$sqlb=$this->sqlBuilder();
		$sql=$sqlb->buildSql($action,$this->_parts);
		//#预处理参数
		$binds=(array)$sqlb->getBindings();
		//每次查询均需要重构语法器
		$this->_parts=[];
		return [$sql,$binds];
	}
	/**
	 * - 一次性的表名
	 * - 只在当前查询有效
	 *
	 * @param string $table 表名，不包含前缀
	 * @return $this
	 */
	public function table($table){
		$this->_parts[SqlBuilderInterface::TABLE]=$this->getPrefix().$table;
		return $this;
	}
	/**
	 * - 一次性的表名
	 * - 只在当前查询有效
	 *
	 * @param string $table 完整的表名，包含前缀
	 * @return $this
	 */
	public function realtable($table){
		$this->_parts[SqlBuilderInterface::TABLE]=$table;
		return $this;
	}
	/**
	 * - 查询条件where
	 * - and连接
	 * 
	 * ->where('')->update([]);
	 * ->where([])->select();
	 * ->where(new Where())->select();
	 * 
	 * @param mixed $value
	 * @return $this
	 */
	public function where($value){
		$this->_parts[SqlBuilderInterface::WHERE]=$value;
		return $this;
	}
	/**
	 * 连接符号,and/or
	 * 只在数组的情况下有效
	 * 
	 * @param string $conn
	 * @return $this
	 */
	public function where_conn($conn=SqlBuilderInterface::O_R){
		$this->_parts[SqlBuilderInterface::WHERE_CONN]=$conn;
		return $this;
	}
	/**
	 * 查询字段field数组类型
	 *
	 * @name fieldSata
	 * @param array $value
	 * @return $this
	 */
	public function fields($value){
		$this->_parts[SqlBuilderInterface::FIELDS]=$value;
		return $this;
	}
	/**
	 * 排序方式
	 *
	 * @param string $value
	 * @return $this
	 */
	public function orderby($value){
		$this->_parts[SqlBuilderInterface::ORDERBY]=$value;
		return $this;
	}
	/**
	 * 结果行限制
	 *
	 * @param string $value
	 * @return $this
	 */
	public function limit($value){
		$this->_parts[SqlBuilderInterface::LIMIT]=$value;
		return $this;
	}
	/**
	 * 读取数据并申请一个读锁，排它锁
	 * - innodb才支持?
	 * - 事务才支持?
	 * - FOR UPDATE
	 * 
	 * @see \qing\db\ddl\Lock
	 * @return $this
	 */
	public function forUpdate(){
		$this->_parts[SqlBuilderInterface::LOCK]=SqlBuilderInterface::FOR_UPDATE;
		return $this;
	}
	/**
	 * 读取数据并申请一个读锁，共享锁
	 * - innodb才支持?
	 * - 事务才支持?
	 * - LOCK IN SHARE MODE
	 * 
	 * @see \qing\db\ddl\Lock
	 * @return $this
	 */
	public function lockShare(){
		$this->_parts[SqlBuilderInterface::LOCK]=SqlBuilderInterface::LOCK_SHARE;
		return $this;
	}
	/**
	 * 数据分组
	 *
	 * @param string $groupby
	 * @return $this
	 */
	public function groupby($groupby){
		$this->_parts[SqlBuilderInterface::GROUPBY]=$groupby;
		return $this;
	}
	/**
	 * - 筛选：聚合后数据，统计后数据，分组后数据
	 * - where只能筛选统计前数据，WHERE 关键字无法与聚合函数一起使用
	 * 
	 * @param string $having
	 * @return $this
	 */
	public function having($having){
		$this->_parts[SqlBuilderInterface::HAVING]=$having;
		return $this;
	}
	/**
	 * select 查询数据集
	 *
	 * @name findAll
	 * @return array
	 */
	public function select(){
		list($sql,$binds)=$this->buildSql(SqlBuilderInterface::SELECT);
		return $this->query($sql,$binds);
	}
	/**
	 * 查找并返回一行记录
	 *
	 * @name findRow
	 * @return array
	 */
	public function find(){
		$this->limit('0,1');//限制只取一行
		list($sql,$binds)=$this->buildSql(SqlBuilderInterface::SELECT);
		return $this->queryRow($sql,$binds);
	}
	/**
	 * 查找并返回一行记录中的一个字段
	 * 
	 * @param string $field 为空则返回第一个字段
	 * @return string
	 */
	public function findField($field){
		$this->fields($field);//只返回那个字段
		$row=$this->find();
		return isset($row[$field])?$row[$field]:null;//返回字段
	}
	/**
	 * 替换
	 * - 所有字段都会被新数据替换，不好。
	 * - insertUpdate:如果存在则更新某些字段
	 * 
	 * @see $this :: insertUpdate
	 * @param array $data
	 * @return boolean/number
	 */
	public function replace(array $data){
		return $this->insert($data,SqlBuilderInterface::REPLACE);
	}
	/**
	 * 替换多行数据
	 *
	 * @param array $data
	 * @return boolean/number
	 */
	public function replaces(array $data){
		return $this->inserts($data,SqlBuilderInterface::REPLACES);
	}
	/**
	 * 插入数据
	 *
	 * @param $data 数据
	 * @param $action insert/replace
	 * @return boolean/number
	 */
	public function insert(array $data,$action=SqlBuilderInterface::INSERT){
		//#插入数据为空
		if(!$data){
			throw new exceptions\ModelException('insert : data数据不能为空');
		}
		//
		$this->_parts[SqlBuilderInterface::KEYS]  =array_keys($data);
		$this->_parts[SqlBuilderInterface::VALUES]=$data;
		//
		list($sql,$binds)=$this->buildSql($action);
		//
		$res=$this->execute($sql,$binds);
		if($res===false){
			return false;
		}else{
			$insertId=(int)$this->getInsertId();
			if($insertId>0){
				//当表中没有主键的时候，没法返回插入后的主键id，直接返回true
				return $insertId;
			}else{
				return true;
			}
		}
	}
	/**
	 * 插入多行数据
	 *
	 * @param array $datas 多行数据
	 * @param string $action inserts/replaces
	 * @return boolean/number
	 */
	public function inserts(array $datas,$action=SqlBuilderInterface::INSERTS){
		//#插入数据为空
		if(!$datas){
			throw new exceptions\ModelException('insert : data数据不能为空');
		}
		//
		$this->_parts[SqlBuilderInterface::KEYS]  =array_keys($datas[0]);
		$this->_parts[SqlBuilderInterface::VALUES]=$datas;
		//
		$sql=$this->buildSql($action);
		$res=$this->execute($sql[0],$sql[1]);
		//getInsertId：只是第一行的id
		return (bool)$res;
	}
	/**
	 * - 有重复异常则更新某些字段;否则插入
	 * - id主键或unique字段重复则更新
	 * -----
	 * num =num+3			//原始记录的值自加3
	 * num =VALUES(num)+3   //取得插入的值自加3
	 * -----
	 * insert into  %table% %keys% values %values% ON DUPLICATE KEY UPDATE %updates%
	 * 
	 * # VALUES:引用新数据
	 * - 数组：->insertUpdate(['id','name'],['id','name']) |要更新的字段|格式化为：id=VALUES(id),name=VALUES(name)
	 * - 字符串：->insertUpdate(['id','name'],' id=VALUES(id),name=VALUES(name) ')
	 * - array(' id=id+1 ',' `count`=VALUES(`count`)+1 ') | 原始数据+1,新数据+1
	 * 
	 * @warning 索引命中率问题？
	 * @param array $data			插入的数据
	 * @param string/array $updates	重复冲突，更新字段映射
	 * @return boolean
	 */
	public function insertUpdate(array $data,$updates){
		//#插入数据为空
		if(!$data || !$updates){
			throw new exceptions\ModelException('insertUpdate : data/updates 参数缺少');
		}
		//
		$this->_parts[SqlBuilderInterface::KEYS]   =array_keys($data);
		$this->_parts[SqlBuilderInterface::VALUES] =$data;
		$this->_parts[SqlBuilderInterface::UPDATES]=$updates;
		//
		list($sql,$binds)=$this->buildSql(SqlBuilderInterface::INSERT_UPDATE);
		$res=$this->execute($sql,$binds);
		return $res;
	}
	/**
	 * 更新一个字段
	 *
	 * @param string $field
	 * @throws Exception
	 * @return boolean
	 */
	public function updateField($field,$value){
		return $this->update([$field=>$value]);
	}
	/**
	 * - update test01 set `ip`='127.0.0.1' where `id`='1197'
	 * - 指定更新条件：data|set
	 * - ->set(" `num`=`num`+1 ")->update();
	 * - ->update(['name'=>'qingmvc']);
	 * 
	 * # update %table% set %set%  %where%
	 * 
	 * @param array $data|可以为空,使用set
	 * @return boolean
	 */
	public function update(array $data=[]){
		//#更新数据必须限定条件
		if(!$this->_parts[SqlBuilderInterface::WHERE]){
			throw new exceptions\ModelException('update: where条件缺失');
		}
		if($data){
			//#可以为空,使用set
			$this->set($data);
		}
		list($sql,$binds)=$this->buildSql(SqlBuilderInterface::UPDATE);
		return $this->execute($sql,$binds);
	}
	/**
	 * - update test01 set `num`=`num`+1 where `id`=1
	 * - ->set(" `num`=`num`+1 ")->update();
	 * - ->set(['name'=>'***'])->update(); 
	 * - ->update(['name'=>'***'])
	 * 
	 * `num`=`num`+1,'name'=>'xiaowang'
	 * 
	 * @param string/array $value
	 * @return $this
	 */
	public function set($value){
		$this->_parts[SqlBuilderInterface::SET]=$value;
		return $this;
	}
	/**
	 * 自增
	 *
	 * @name increment
	 * @param string $field 自增字段
	 * @return boolen
	 */
	public function inc($field){
		return $this->set(" `{$field}`=`{$field}`+1 ")->update();
	}
	/**
	 * 自增
	 * 
	 * @name decrement
	 * @param string $field 自减字段
	 * @return boolen
	 */
	public function dec($field){
		return $this->set(" `{$field}`=`{$field}`-1 ")->update();
	}
	/**
	 * 删除
	 *
	 * @throws \Exception
	 * @return boolean
	 */
	public function delete(){
		//#删除数据必须限制条件
		if(!$this->_parts[SqlBuilderInterface::WHERE]){
			throw new exceptions\ModelException('delete: where条件缺失');
		}
		list($sql,$binds)=$this->buildSql(SqlBuilderInterface::DELETE);
		return $this->execute($sql,$binds);
	}
	/**
	 * 统计
	 * 语法|select count(*) as count from  %table%  %where%
	 * 
	 * @return number
	 */
	public function count(){
		$this->fields('count(*) as count');
		list($sql,$binds)=$this->buildSql(SqlBuilderInterface::SELECT);
		$row=$this->queryRow($sql,$binds);
		if(!$row){
			return 0;
		}else{
			return (int)$row['count'];
		}
	}
	/**
	 * 检测记录是否存在|检测是否为空
	 * 当拥有很多记录时使用count提高效率
	 * 
	 * - myisam:count(*)速度很快
	 * - innodb:则不一定
	 * - limit 0,1 只获取一行
	 * 
	 * @deprecated
	 * @see exists/has
	 * @return boolean true/false
	 */
	public function has(){
		$count=$this->count();
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 检测记录是否存在
	 *
	 * - myisam:count(*)速度很快
	 * - innodb:则不一定
	 * - limit 0,1 只获取一行
	 *
	 * @return boolean true/false
	 */
	public function exists(){
		$this->orderby('');//去除所有排序
		$this->limit('0,1');//只取一行数据
		return !!$this->select();//空数组还是非空数组
	}
	/**
	 * @see \qing\db\BaseModel::lockTablesRead()
	 */
	public function lockTablesRead($table=''){
		return parent::lockTablesRead($table?$table:$this->_getLiveTableName());
	}
	/**
	 * @see \qing\db\BaseModel::lockTablesReadLocal()
	 */
	public function lockTablesReadLocal($table=''){
		return parent::lockTablesReadLocal($table?$table:$this->_getLiveTableName());
	}
	/**
	 * @see \qing\db\BaseModel::lockTablesWrite()
	 */
	public function lockTablesWrite($table=''){
		return parent::lockTablesWrite($table?$table:$this->_getLiveTableName());
	}
	/**
	 * 实时表名
	 *
	 * @return string
	 */
	protected function _getLiveTableName(){
		if(isset($this->_parts[SqlBuilderInterface::TABLE])){
			$table=$this->_parts[SqlBuilderInterface::TABLE];
			//重置，一次查询完成
			$this->_parts=[];
			return $table;
		}else{
			return $this->getRealTableName();
		}
	}
}
?>
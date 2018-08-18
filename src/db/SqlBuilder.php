<?php 
namespace qing\db;
use qing\com\Component;
/**
 * sql创建器
 * SQL语法|数据容器
 * SQL:Structured Query Language|结构化查询语言
 * 约定：关键字使用大写，和mysql文档一致
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SqlBuilder extends Component implements SqlBuilderInterface{
	/**
	 * 是否支持绑定预处理参数
	 *
	 * @var boolean
	 */
	public $bindOn=true;
	/**
	 * 数据库类型
	 *
	 * @var string
	 */
	public $type='mysql';
	/**
	 * - 预处理占位符对应数据
	 * - 命名占位符:name
	 * - 问号占位符:?
	 *
	 * @var array
	 */
	protected $_bindings=[];
	/**
	 * @var array
	 */
	protected $_structures=[];
	/**
	 * @var array
	 */
	protected $_parts=[];
	/**
	 * 初始化语法结构
	 */
	protected function initStructures(){
		$this->_structures=(array)include __DIR__.'/structures/'.$this->type.'.php';
	}
	/**
	 * @see \qing\com\ComponentInterface::initComponent()
	 */
	public function initComponent(){
		$this->initStructures();
	}
	/**
	 */
	public function binds(array $binds){
		foreach($binds as $v){
			$this->_bindings[]=$v;
		}
	}
	/**
	 * 构建sql语句
	 * 置空 sql组装数据数组，以免影响下次查询 ;包括表名 否则会影响下次查询
	 * 每一次数据库操作的 条件都不一样 必须重置
	 *
	 * @param string $action SQL操作|select|delete
	 * @param array $parts
	 * @return string|mixed
	 */
	public function buildSql($action,array $parts){
		//#必须先重置|每次查询都使用该实例
		$this->_bindings=[];
		$this->_parts=$parts;
		if(!isset($this->_structures[$action])){
			throw new \Exception('SQL语法结构不存在:'.$action);
		}
		//sql操作语法|包含占位符
		$stru=$this->_structures[$action];
		//只处理当前语法拥有的占位符
		$sql=preg_replace_callback('/\%([0-9a-z-_]+)\%/i',function($matches){
			$field=$matches[1];
			if(isset($this->_parts[$field])){
				$value=$this->_parts[$field];
				unset($this->_parts[$field]);
			}else{
				$value='';
			}
			$method='_'.strtolower($field);
			if(method_exists($this,$method)){
				//#格式化
				$value=(string)$this->$method($value);
			}
			return $value;
		},$stru);
		return $sql;
	}
	/**
	 * 排序预处理参数|根据values/keys/where/set
	 *
	 * @tutorial 索引键值，从1开始
	 * @return array
	 */
	public function getBindings(){
		$bindings=[];
		$indexKey=1;
		foreach($this->_bindings as $row){
			//list($field,$value)=(array)$row;
			$bindings[$indexKey]=$row[1];
			$indexKey++;
		}
		return $bindings;
	}
	/**
	 * 字段处理
	 * 
	 * - 必须使用反引号，转义保留词语,否则语法错误|`key`|select * from tb where `key`=123
	 * - 数据库前缀问题？自己组建sql
	 * 
	 * @since 2017.04.30 
	 * @param string $value 字段值
	 * @return string
	 */
	protected function getField($value){
		return "`{$value}`";
	}
	/**
	 * 格式化参数值
	 *
	 * @param string $value  	字段值
	 * @param string $field 	字段名称
	 * @return string/'str'/?
	 */
	protected function getValue($value,$field=null){
		if(!$this->bindOn){
			//#不开启预处理
			return "'{$value}'";
		}else{
			//#开启预处理
			$this->_bindings[]=[$field,$value];
			return '?';
		}
	}
	/**
	 * @param string/array $fields
	 * @return string
	 */
	protected function _fields($fields){
		if(!$fields){
			//#为空
			$fields='*';
		}else if(is_array($fields)){
			//#数组
			$fields='(`'.implode('`,`',$fields).'`)';
		}
		return $fields;
	}
	/**
	 * @param string/array $keys
	 */
	protected function _keys($keys){
		if(is_array($keys)){
			//#数组
			$keys='(`'.implode('`,`',$keys).'`)';
		}
		return $keys;
	}
	/**
	 * @param string $values
	 */
	protected function _values($values){
		if(is_array($values)){
			/*
			$values=array_map(function($value){
				return $this->getValue($value);
			},$values);
			*/
			array_walk($values,function(&$value,$key){
				$value=$this->getValue($value,$key);
			});
			//#数组
			$values='('.implode(',',$values).')';
		}
		return $values;
	}
	/**
	 * `num`=`num`+1,'name'='xiaowang'
	 * 
	 * @param string $set
	 */
	protected function _set($set){
		if(is_array($set)){
			//#数组
			$arr=[];
			foreach($set as $field=>$value){
				$value=$this->getValue($value,$field);
				$field=$this->getField($field);
				$arr[]=$field.'='.$value;
			}
			$set=implode(',',$arr);
		}
		return $set;
	}
	/**
	 * 冲突时的更新字段
	 *
	 * - 数组：->insertUpdate(['id','name'],['id','name']) |要更新的字段|格式化为：id=VALUES(id),name=VALUES(name)
	 * - 字符串：->insertUpdate(['id','name'],' id=VALUES(id),name=VALUES(name) ')
	 * - array(' id=id+1 ',' `count`=VALUES(`count`)+1 ') | 原始数据+1,新数据+1
	 *
	 * @param string $updates
	 * @return string
	 */
	protected function _updates($updates){
		if(is_array($updates)){
			//#数组|要更新的字段|VALUES取得新数据
			$updates=array_map(function($field){
				return "`{$field}`=VALUES(`{$field}`)";
			},$updates);
			$updates=implode(',',$updates);
		}
		return $updates;
	}
	/**
	 * 重写父类方法
	 * throw new \Exception('where条件不能为空'));
	 * 
	 * @param string $where
	 * @return string
	 */
	protected function _where($where){
		if(!$where){
			//#空字符/空数组
			return '';
		}
		if(is_array($where)){
			//#数组
			$where=$this->_where_array($where);
		}elseif($where instanceof WhereInterface){
			//#Where对象/注意:不要返回空
			$where=$this->_where_object($where);
		}else{
			//#字符串
			$where=(string)$where;
			//$where=trim($where);
		}
		return 'WHERE '.$where;
	}
	/**
	 * ['id'=>'1','name'=>'qing']
	 * 总是以and连接
	 * and/or
	 * 
	 * @param array $where
	 */
	protected function _where_array(array $where){
		$arr=[];
		foreach($where as $field=>$value){
			$value=$this->getValue($value,$field);
			$field=$this->getField($field);
			$arr[]=$field.'='.$value;
		}
		//where条件连接符//or/and
		if(isset($this->_parts[self::WHERE_CONN])){
			$connector=$this->_parts[self::WHERE_CONN];
			unset($this->_parts[self::WHERE_CONN]);
		}else{
			$connector=self::A_N_D;
		}
		$sql=' '.implode(" {$connector} ",$arr).' ';
		return $sql;
	}
	/**
	 * @param WhereInterface $where
	 */
	protected function _where_object(WhereInterface $where){
		$sql  =(string)$where->getWhere($this->bindOn);
		$binds=(array)$where->getBindings();
		if($binds){
			$this->binds($binds);
		}
		return $sql;
	}
	/**
	 * @param string $orderby
	 * @return string
	 */
	protected function _orderby($orderby){
		if(!$orderby){
			return '';
		}
		return 'ORDER BY '.$orderby;
	}
	/**
	 * @param string $limit
	 * @return string
	 */
	protected function _limit($limit){
		if(!$limit){
			return '';
		}
		return 'LIMIT '.$limit;
	}
	/**
	 * @param string $lock
	 * @return string
	 */
	protected function _lock($lock){
		return $lock;
	}
	/**
	 * @param string $groupby
	 * @return string
	 */
	protected function _groupby($groupby){
		if(!$groupby){
			return '';
		}
		return 'GROUP BY '.$groupby;
	}
	/**
	 * @param string $having
	 * @return string
	 */
	protected function _having($having){
		if(!$having){
			return '';
		}
		return 'HAVING '.$having;
	}
}
?>
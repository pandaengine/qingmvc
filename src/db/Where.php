<?php
namespace qing\db;
/**
 * - 查询条件
 * - where条件
 * -----
 * eq 等于
 * neq 不等于
 * gt  大于|greater than
 * egt 大于等于
 * lt  小于|less than
 * elt 小于等于
 * like LIKE
 * between BETWEEN
 * notnull IS NUT NULL
 * null IS NULL
 * -----
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Where implements WhereInterface{
	/**
	 * 条件字符串
	 * - 查询条件
	 * - name LIKE ? | id LIKE :id
	 *
	 * @var array
	 */
	protected $where=[];
	/**
	 * - 预处理占位符对应数据
	 * - 命名占位符:name
	 * - 问号占位符:?
	 *
	 * @var array
	 */
	protected $bindings=[];
	/**
	 * 是否开启绑定预处理参数
	 *
	 * @var boolean
	 */
	protected $bindOn=true;
	/**
	 * 二次格式化方法
	 * 
	 * @var array
	 */
	protected $formaters=['in','between'];
	/**
	 * 字段处理
	 * - 是否使用反引号
	 * - 是否使用数据库前缀
	 * return "`{$field}`";
	 *
	 * @param string $field
	 * @return string
	 */
	protected function getField($field){
		return $field;
	}
	/**
	 * 格式化参数值
	 *
	 * @param string $value	字段值
	 * @param string $field	原始字段名称|未经过getField
	 * @return string
	 */
	protected function getValue($value,$field=null){
		if(!$this->bindOn){
			//#不开启预处理
			if(is_numeric($value)){
				//没有引号
				return $value;
			}else{
				//有引号
				$value=addcslashes($value,"'");
				return "'{$value}'";
			}
		}else{
			//#开启预处理
			$this->bindings[]=[$field,$value];
			return '?';
		}
	}
	/**
	 * 获取预处理占位符参数
	 *
	 * @return array
	 */
	public function getBindings(){
		return $this->bindings;
	}
	/**
	 * 取得条件
	 * 注意：
	 * - 执行之后，数据被销毁，再执行将返回空!顾名思义，不要执行多次
	 * - 要使用多次 ，可以可怜对象，$whereClone=clone $where;
	 * 
	 * @param boolean $bindOn
	 * @return string
	 */
	public function getWhere($bindOn=true){
		$this->bindOn=$bindOn;
		$where='';
		$first=true;
		foreach($this->where as $k=>$row){
			unset($this->where[$k]);
			list($_field,$_value,$_oper,$_conn)=$row;
			if($_oper){
				//#><=in
				if(in_array($_oper,$this->formaters)){
					//#自定义格式化|id in (?,?,?)
					// && method_exists($this,$formater)
					$formater='__'.$_oper;
					$_where=call_user_func_array([$this,$formater],[$_field,$_value]);
				}else{
					//#默认格式|id=?
					$field=$this->getField($_field);
					$value=$this->getValue($_value,$_field);
					$_where=$field.' '.$_oper.' '.$value;
				}
			}else{
				//#分组括号()|或是整条条件语句"id=1"|不需要操作符oper和值val
				$_where=$_field;
			}
			if($first){
				//#第一行|改变标识
				$first=false;
				$_conn='';
			}
			$where=$where.' '.$_conn.' '.$_where;
			//#经过一个分组左括号|置零
			if($_field==self::GROUP_LEFT){
				$first=true;
			}
		}
		//清空数据
		$this->where=[];
		return $where;
	}
	/**
	 * 添加一条查询条件到where
	 * $this->set('id','123','and')
	 *
	 * @name setValue
	 * @param string $field 	字段名称
	 * @param string $value  	字段值
	 * @param string $operator  操作符|=></like/not like
	 * @param string $connector 操作符|and/or
	 * @return  $this
	 */
	public function set($field,$value,$operator='',$connector=self::A_N_D){
		$this->where[]=[$field,$value,$operator,$connector];
		return $this;
	}
	/**
	 * 整条条件语句id=1
	 *
	 * @name push
	 * @param string $sql
	 * @param string $connector
	 * @return $this
	 */
	public function sql($sql,$connector=self::A_N_D){
		$this->set($sql,'','',$connector);
		return $this;
	}
	/**
	 * 新增一个条件，使用and链接
	 *
	 * @return $this
	 */
	public function a_n_d($sql){
		return $this->sql($sql,self::A_N_D);
	}
	/**
	 * 新增一个条件，使用or链接
	 *
	 * @return $this
	 */
	public function o_r($sql){
		return $this->sql($sql,self::O_R);
	}
	/**
	 * 等于
	 *
	 * @name equal
	 * @param string $field 	字段名称
	 * @param string $value  	字段值
	 * @param string $connector 操作符/and/or
	 * @return  $this
	 */
	public function eq($field,$value,$connector=self::A_N_D){
		return $this->set($field,$value,'=',$connector);
	}
	/**
	 * 大于
	 *
	 * @name greater than
	 * @param string $field 	字段名称
	 * @param string $value  	字段值
	 * @param string $connector 操作符/and/or
	 * @return  $this
	 */
	public function gt($field,$value,$connector=self::A_N_D){
		return $this->set($field,$value,'>',$connector);
	}
	/**
	 * 大于等于
	 *
	 * @name greater than | gte
	 * @param string $field 	字段名称
	 * @param string $value  	字段值
	 * @param string $connector 操作符/and/or
	 * @return  $this
	 */
	public function ge($field,$value,$connector=self::A_N_D){
		return $this->set($field,$value,'>=',$connector);
	}
	/**
	 * 小于
	 *
	 * @name less than
	 * @param string $field 	字段名称
	 * @param string $value  	字段值
	 * @param string $connector 操作符/and/or
	 * @return  $this
	 */
	public function lt($field,$value,$connector=self::A_N_D){
		return $this->set($field,$value,'<',$connector);
	}
	/**
	 * 小于等于
	 *
	 * @name less equal
	 * @param string $field 	字段名称
	 * @param string $value  	字段值
	 * @param string $connector 操作符/and/or
	 * @return  $this
	 */
	public function le($field,$value,$connector=self::A_N_D){
		return $this->set($field,$value,'<=',$connector);
	}
	/**
	 * 添加一条between查询条件到where
	 *
	 * @param string $field		     相应字段
	 * @param string $valueStart  起始值
	 * @param string $valueEnd    终止值
	 * @param string $connector   操作符/and/or
	 * @return $this
	 */
	public function between($field,$valueStart,$valueEnd,$connector=self::A_N_D){
		return $this->set($field,[$valueStart,$valueEnd],self::BETWEEN,$connector);
	}
	/**
	 * 添加一条between查询条件到where
	 *
	 * @param string $field
	 * @param array  $value
	 * @return string
	 */
	protected function __between($field,array $value){
		list($valueStart,$valueEnd)=$value;
		$valueStart	=$this->getValue($valueStart,$field);
		$valueEnd	=$this->getValue($valueEnd,$field);
		$field		=$this->getField($field);
		$sql=" ( {$field} between {$valueStart} and {$valueEnd} ) ";
		return $sql;
	}
	/**
	 * 添加一条IN查询条件到where|id in(1,2,3)
	 * $this->in('id',[1,2,3]))
	 * $this->in('id','1,2,3')
	 *
	 * @param string $field    条件字段
	 * @param string $values   值
	 * @param string $connector 操作符/and/or
	 * @return $this
	 */
	public function in($field,$value,$connector=self::A_N_D){
		return $this->set($field,$value,self::I_N,$connector);
	}
	/**
	 * @param string $field    条件字段
	 * @param string $values   值
	 * string:1,2,3
	 * array:[1,2,3]
	 * @return $this
	 */
	protected function __in($field,$value){
		if(is_array($value)){
			//#数组
			$ins=[];
			foreach($value as $v){
				//#绑定数据字段名称
				$ins[]=$this->getValue($v,$field);
			}
			$value=implode(',',$ins);
		}
		$field=$this->getField($field);
		$sql=$field.' in ('.$value.')';
		return $sql;
	}
	/**
	 * 搜索/模糊查找条件
	 * 
	 * #$escape 是否转义like相关字符/_:一个字符 %:多个字符
	 * - '_' 单个字符通配符
	 * - '%' 多个字符通配符
	 * - addcslashes($value,'_%');
	 * ---
	 * where name like '%av/%%' escape '/';
	 * where name like '%av\%%' escape '\\';
	 * 
	 * @param string $field     搜索的字段
	 * @param string $value   	搜索关键字/注意要包含模糊符号%_|'%'.$keyword.'%';|"%ab\_\%c%"
	 * @param string $connector 连接符/and/or
	 * @param string $operator  操作符/like/not like
	 * @return $this
	 */
	public function like($field,$value,$connector=self::A_N_D){
		return $this->set($field,$value,'like',$connector);
	}
	public function notlike($field,$value,$connector=self::A_N_D){
		return $this->set($field,$value,'not like',$connector);
	}
	/**
	 * 条件分组|查询条件分组
	 * 括号分组()|左边符号
	 *
	 * ## 注意OR/AND混用逻辑错误问题|注意使用括号分组
	 *
	 * (n. NAME LIKE '%回%') AND  (n.ctrl LIKE '%c%' OR n.action LIKE '%c%' OR n.QUERY LIKE '%c%' )
	 *
	 * @name group left
	 * @param string $connector 操作符/and/or
	 * @return $this
	 */
	public function gleft($connector=self::A_N_D){
		$this->set(self::GROUP_LEFT,'','',$connector);
		return $this;
	}
	/**
	 * 分组右边符号
	 *
	 * @return $this
	 */
	public function gright(){
		$this->set(self::GROUP_RIGHT,'','','');
		return $this;
	}
}
?>
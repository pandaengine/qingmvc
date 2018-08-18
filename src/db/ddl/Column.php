<?php
namespace qing\db\ddl;
/**
 * 表字段列Schema规范模版
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Column{
	/**
	 * 字段列名称
	 * @var string
	 */
	public $name;
	/**
	 * 是否允许为空
	 * @var boolean
	 */
	public $allowNull;
	/**
	 * 字段类型(数据库表述)
	 * @var string
	 */
	public $dbType;
	/**
	 * 字段类型(PHP表述)
	 * @var string
	 */
	public $type;
	/**
	 * 字段默认值
	 *
	 * @var mixed
	 */
	public $defaultValue;
	/**
	 * 字段显示宽度/不影响存储数据长度只影响左填充0
	 * int(11)/varchar(255)
	 * @var integer
	 */
	public $size;
	/**
	 * 当前字段列是否是主键
	 * @var boolean
	 */
	public $isPrimaryKey;
	/**
	 * 当前字段列是否是外键
	 * @var boolean
	 */
	public $isForeignKey;
	/**
	 * 当前字段列是否是自增的
	 * @var boolean
	 */
	public $autoIncrement=false;
	/**
	 * 当前字段列的注释
	 * @var string
	 */
	public $comment='';
	/**
	 * 初始化
	 * 
	 * @param string $dbType 类类型
	 * @param mixed $defaultValue 默认值
	 */
	public function init($dbType,$defaultValue){
		$this->dbType=$dbType;
		$this->parseType($dbType);
		if($defaultValue!==null){
			$this->parseDefault($defaultValue);
		}
	}
	/**
	 * 把数据库类型解析成PHP类型|解析数据类型
	 * 
	 * @param string $dbType
	 */
	protected function parseType($dbType){
		if(stripos($dbType,'int')!==false && stripos($dbType,'unsigned int')===false){
			$this->type='integer';
		}elseif(stripos($dbType,'bool')!==false){
			$this->type='boolean';
		}elseif(preg_match('/(real|floa|doub)/i',$dbType)){
			$this->type='double';
		}else{
			$this->type='string';
		}
	}
	/**
	 * 解析默认值
	 *
	 * @param mixed $defaultValue
	 */
	protected function parseDefault($defaultValue){
		$this->defaultValue=$this->typecast($defaultValue);
	}
	/**
	 * 
	 * @param mixed $value 
	 * @return mixed
	 */
	public function typecast($value){
		if(gettype($value)===$this->type || $value===null){
			return $value;
		}
		if($value==='' && $this->allowNull){
			return $this->type==='string'?'':null;
		}
		switch($this->type){
			case 'string':
				return (string)$value;
			case 'integer':
				return (integer)$value;
			case 'boolean':
				return (boolean)$value;
			case 'double':
			default:
				return $value;
		}
	}
}
?>
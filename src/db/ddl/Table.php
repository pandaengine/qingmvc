<?php
namespace qing\db\ddl;
/**
 * 表规范模版Schema规范
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Table{
	/**
	 * 表名
	 * @var string 
	 */
	public $name;
	/**
	 * 表主键|有多个主键则返回数组|pk
	 * PRIMARY KEY (Id_O)
	 * 
	 * @var string/array
	 */
	public $primaryKey;
	/**
	 * 外键|外键名称和对应的表字段的映射数组
	 * FOREIGN KEY (Id_P) REFERENCES Persons(Id_P)
	 * 
	 * @var array
	 */
	public $foreignKeys=array();
	/**
	 * 表字段/列|字段名和DbColumnSchema对象的映射|fields
	 * ['name':new DbColumnSchema]
	 * @var array
	 */
	public $columns=array();
	/**
	 * 获取一个字段列的metadata元数据
	 *
	 * @param string $name 列名
	 * @return DbColumnSchema
	 */
	public function getColumn($name){
		return isset($this->columns[$name])?$this->columns[$name]:null;
	}
	/**
	 * 返回字段列的名称
	 * @return array
	 */
	public function getColumnNames(){
		return array_keys($this->columns);
	}
}
?>
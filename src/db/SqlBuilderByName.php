<?php 
namespace qing\db;
/**
 * 使用命名占位符绑定参数
 * id=:id,[123]
 * 
 * - 命名占位符        |name=:name
 * - 问号索引占位符|name=?
 *
 * @var boolean $bindBN
 * @name Sql Builder bind by name
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SqlBuilderByName extends SqlBuilder{
	/**
	 * # 命名占位符字段重复覆盖问题
	 * # in(:id_1,:id_2,id_3)
	 *
	 * @var array
	 */
	protected $fieldNames=[];
	/**
	 * 排序预处理参数|根据values/keys/where/set
	 *
	 * @return array
	 */
	public function getBindings(){
		$bindings=[];
		foreach($this->bindings as $row){
			list($field,$value)=(array)$row;
			$bindings[$field]=$value;
		}
		return $bindings;
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
			$field=$this->getFieldName($field);
			$this->bindings[]=array($field,$value);
			return ':'.$field;
		}
	}
	/**
	 * 命名占位符
	 * 
	 * @name getBindHolder
	 * @param string $field
	 * @return string
	 */
	protected function getFieldName($field){
		if(!$field){
			//#名称为空时|f_1,f_2
			$field='f';
		}
		if(in_array($field,$this->fieldNames)){
			//#避免命名占位符重复
			//$field=$field.'_'.substr(uniqueId(),-6);
			$field=$field.'_'.count($this->fieldNames);
		}
		$this->fieldNames[]=$field;
		return $field;
	}
}
?>
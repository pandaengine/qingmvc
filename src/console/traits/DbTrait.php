<?php
namespace qing\console\traits;
use qing\db\Db;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */
trait DbTrait{
	/**
	 * @var array
	 */
	public $tables=[];
	/**
	 * 定义多个itct，并使用不同的链接即可
	 * 
	 * @var string
	 */
	public $connName='';
	/**
	 * @return \qing\db\Connection
	 */
	protected function getConn(){
		return Db::conn($this->connName);
	}
	/**
	 * 获取表
	 *
	 * @return array
	 */
	protected function getTables(){
		if($this->tables){
			//#自定义表|不包含前缀
			$pre=$this->getConn()->getPrefix();
			$tables=[];
			//#追加前缀
			foreach($this->tables as $table){
				$tables[]=$pre.$table;
			}
			return $tables;
		}
		//#全部表
		$tables=[];
		$rows=$this->getConn()->query("SHOW TABLES");
		foreach($rows as $row){
			$tables[]=current($row);
		}
		return $tables;
	}
	/**
	 * 获取表字段列表
	 *
	 * @param string $tableName 表全名
	 * @return array
	 */
	protected function getTableFields($realTable){
		$fields=$this->getTBFields($realTable);
		$list=[];
		foreach($fields as $field){
			$list[]=$field['Field'];
		}
		return $list;
	}
	/**
	 * 获取表字段列表
	 *
	 * @param string $tableName 表全名
	 * @return array
	 */
	protected function getTBFields($realTable){
		$db	 =$this->getConn();
		//$sql="SHOW FULL FIELDS FROM `{$realTable}`";
		$sql ="SHOW FULL COLUMNS FROM `{$realTable}`";
		$list=$db->query($sql);
		if($list===false){
			//执行错误|
			throw new \qing\exceptions\SqlException($sql,$db->getError());
			return [];
		}
		return (array)$list;
	}
	/**
	 * 获取表字段列表
	 * if($this->appName=='uid_client'){}
	 *
	 * @param string $tableName 表全名
	 * @return array
	 */
	protected function getFields($realTable){
		$list	=$this->getTBFields($realTable);
		$fields	=[];
		$types 	=[];
		$comments=[];
		foreach($list as $field){
			$fieldName=$field['Field'];
			$fieldType=$this->getType($field['Type']);
			//
			$fields[]				=$fieldName;
			$types[$fieldName]		=$fieldType;
			$comments[$fieldName]	=$field['Comment'];
		}
		return [$fields,$types,$comments];
	}
	/**
	 * 把数据库类型解析成PHP类型|解析数据类型
	 * $var=(float)$var;
	 * $var=(int)$var;
	 * $var=(bool)$var;
	 *
	 * @param string $type
	 */
	protected function getType($type){
		if(preg_match('/int/i',$type)){
			//int/tinyint/middleint/bigint/unsigned int
			$type='int';
		}elseif(stripos($type,'bool')!==false){
			$type='bool';
		}elseif(preg_match('/(real|floa|doub)/i',$type)){
			$type='float';
		}else{
			//char/varchar/text
			$type='string';
		}
		return $type;
	}
}
?>
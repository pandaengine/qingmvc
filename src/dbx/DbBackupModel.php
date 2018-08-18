<?php
namespace qing\dbx;
use qing\db\Model;
/**
 * 导出数据模型
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright 2013 http://qingcms.com All rights reserved.
 */
class DbBackupModel extends Model{
	/**
	 * 取得所有库名
	 */
	public function allDatabases(){
		$list=$this->query('SHOW DATABASES');
		$databases=array();
		foreach($list as $row){
			$databases[]=current($row);
		}
		return $databases;
	}
	/**
	 * 数据库是否存在
	 * SHOW DATABASES LIKE '%qingcms%'
	 * 
	 * @param string $db
	 */
	public function existsDatabase($db){
		$dbs=$this->query("SHOW DATABASES LIKE '{$db}' ");
		if(count((array)$dbs)>0){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 取得所有表名
	 * SHOW TABLES FROM `qingcms2014`
	 * 
	 * @param string $db 指定数据库/没有指定，则使用连接时指定的库
	 */
	public function allTables($db=''){
		if($db===''){
			$list=$this->query("SHOW TABLES");
		}else{
			$list=$this->query("SHOW TABLES FROM `{$db}` ");
		}
		$tables=[];
		foreach($list as $row){
			$tables[]=current($row);
		}
		return $tables;
	}
	/**
	 * 备份表结构
	 * AUTO_INCREMENT=[0-9]*
	 * 
	 * @param string $realtable 真实表名|包括库名称|qingcms2014.pre_user
	 * @return string
	 */
	public function backupTable($realtable){
		try{
			$ddl=$this->query('SHOW CREATE TABLE '.$realtable);
			$ddl=next($ddl[0]);
		}catch(\Exception $e){
			$ddl="\n-- 获取表失败:".$e->getMessage();
		}
		return "\n\n--\n-- Table structure for {$realtable}\n--\n".$ddl.";";
	}
	/**
	 * 备份表的数据
	 * 
	 * @param string $realtable 真实表名
	 * @param number $limitRow  导出数据行数限制
	 * @return string
	 */
	public function backupData($realtable,$limitRows=0){
		$limitRows=(int)$limitRows;
		$limit =$limitRows>0?" limit 0,{$limitRows} ":"";
		//
		try{
			$datas=$this->query("SELECT * FROM {$realtable} {$limit}");
			$content=$this->formatData($datas,$realtable);
		}catch(\Exception $e){
			$content="\n-- 获取表数据失败:".$e->getMessage();
		}
		return $content;
	}
	/**
	 * 格式化数据
	 *
	 * @param array $datas
	 * @param string $realtable
	 */
	public function formatData(array $datas,$realtable){
		$content="\n\n--\n-- Table data for {$realtable}\n--\n\n";
		if(!$datas){
			//无数据
			return $content."-- data is empty ";
		}
		foreach($datas as $k=>$row){
			//遍历所有行
			$fields=[];
			$values=[];
			foreach($row as $field=>$value){
				//遍历字段
				$value=(string)$value;
				//转义单引号
				$value=addcslashes($value,"'");
				$value="'{$value}'";
				$fields[]="`{$field}`";
				$values[]=$value;
			}
			$_fields=implode(',',$fields);
			$_values=implode(',',$values);
			$content.="INSERT INTO {$realtable} ({$_fields}) VALUES ({$_values});\n";
		}
		return $content;
	}
}
?>
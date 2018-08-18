<?php
namespace qing\db;
use qing\facades\Coms;
use qing\db\Where;
/**
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Db{
	/**
	 * @param string $conn
	 * @return \qing\db\Connection
	 */
	public static function conn($conn=''){
		return com(static::comid($conn));
	}
	/**
	 * 根据组件名取得连接名称
	 * 
	 * @param string $conn
	 * @return string
	 */
	public static function connName($conn){
		return explode('@',$conn)[1];
	}
	/**
	 * @param string $conn
	 * @return string
	 */
	public static function comid($conn=''){
		$conn=='' && $conn=KEY_MAIN;
		return 'db@'.$conn;
	}
	/**
	 * @name exists
	 * @param string $conn
	 * @return boolean
	 */
	public static function has($conn){
		return Coms::has(static::comid($conn));
	}
	/**
	 * @param string $conn
	 * @return boolean
	 */
	public static function remove($conn){
		return Coms::remove(static::comid($conn));
	}
	/**
	 * @param string $conn
	 * @return boolean
	 */
	public static function removeInstance($conn=''){
		return Coms::removeInstance(static::comid($conn));
	}
	/**
	 * # 不能是负数
	 * # 分页为负问题|p=-878
	 *
	 * @todo limit -1,12/20,12 | You have an error in your SQL syntax;
	 * @return string
	 */
	public static function limit_start($start){
		$start=(int)$start;
		if($start<0){
			$start=0;
		}
		return $start;
	}
	/**
	 * 查询条件
	 *
	 * @name condition wher when
	 * @return \qing\db\Where
	 */
	public static function where(){
		return new Where();
	}
	/**
	 * 查询条件
	 * 
	 * @param string 		$field
	 * @param array/string 	$values
	 * @return \qing\db\Where
	 */
	public static function where_in($field,$value){
		$where=new Where();
		$where->in($field,$value);
		return $where;
	}
	/**
	 * # 不能是负数
	 * # 分页为负问题|p=-878
	 *
	 * @todo limit -1,12/20,12 | You have an error in your SQL syntax;
	 * @return string
	 */
	public static function start($start){
		$start=(int)$start;
		if($start<0){
			$start=0;
		}
		return $start;
	}
}
?>
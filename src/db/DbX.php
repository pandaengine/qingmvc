<?php
namespace qing\db;
use qing\db\Where;
/**
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class DbX{
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
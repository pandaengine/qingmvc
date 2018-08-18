<?php
namespace qing\db;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Sql{
	/**
	 * 格式化数组数据
	 * ['name'=>'qingmvc']
	 * ['id=1','name="qingmvc"']
	 *
	 * @tutorial 不支持预处理参数，使用Where来支持
	 * @name where array|model where
	 * @param array $values
	 * @return string
	 */
	public static function where(array $values){
		$wheres=array();
		foreach($values as $field=>$value){
			if(is_numeric($field)){
				//#键值是数值
				$wheres[]=$value;
			}else{
				$wheres[]=" `{$field}`='{$value}' ";
			}
		}
		return ' '.implode(' and ',$wheres).' ';
	}
	/**
	 * 格式化数组数组为set条件
	 * ~ update test01 set set id=1,name='qingmvc' 	where `id`='1'
	 *
	 * @tutorial ['id'=>1,'name'=>'qingmvc'] , set id=1,name='qingmvc'
	 * @param string $value
	 * @return $this
	 */
	public static function set(array $values){
		$arr=[];
		foreach($values as $k=>$v){
			$arr[]="`{$k}`='{$v}'";
		}
		$set=implode(',',$arr);
		return $set;
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
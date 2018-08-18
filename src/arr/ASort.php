<?php
namespace qing\arr; 
/**
 * 数组排序
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ASort{
	/**
	 * 二维数组排序
	 * asort - 对数组值进行排序并保持索引关系
	 * arsort - 对数组值进行逆向排序并保持索引关系
	 * 
	 * 当排序的元素id值相同时，无法确保原来顺序，排序是随机的
	 * 
	 * @param $arr  需要排序的数组[多维数组]
	 * @param $key  需要排序的字段
	 * @param $type asc/desc 正/逆序
	 */
	public static function sort($arr,$key='id',$type='asc'){
		$key_arr=$new_arr=[];
		//id数组
		foreach($arr as $k=>$v){
			$key_arr[$k]=$v[$key];
		}
		//对id数组排序 
		if($type=='asc'){
			asort($key_arr);
		}else{
			arsort($key_arr);
		}
		//指针重置
		reset($key_arr);
		//根据id排序数组
		foreach($key_arr as $k=>$v){
			$new_arr[$k]=$arr[$k];
		}
		return $new_arr;
	}
	/**
	 * 二维数组排序
	 * 根据某个元素的值进行排序，元素值可能相同
	 *
	 * @param $arr  需要排序的数组[二维数组]
	 * @param $key  需要排序的字段
	 * @param $type asc/desc 正/逆序
	 */
	public static function sortKey($arr,$key='id',$sort=SORT_ASC,$sort_flags=SORT_NUMERIC){
		$key_arr=[];
		//id数组
		foreach($arr as $k=>$v){
			$key_arr[$k]=$v[$key];
		}
		//根据字典$key_arr排序，$key_arr值相同时再根据$arr值排序
		array_multisort($key_arr,$sort,$sort_flags,$arr);
		return $arr;
	}
	/**
	 * array_multisort() 函数对多个数组或多维数组进行排序。
	 *
	 * 参数中的数组被当成一个表的列并以行来进行排序-这类似 SQL 的 ORDER BY子句的功能。
	 * 第一个数组是要排序的主要数组。数组中的行（值）比较为相同的话，就会按照下一个输入数组中相应值的大小进行排序，依此类推。
	 *
	 * 第一个参数是数组，随后的每一个参数可能是数组，也可能是下面的排序顺序标志（排序标志用于更改默认的排列顺序）之一：
	 * SORT_ASC - 默认，按升序排列。(A-Z)
	 * SORT_DESC - 按降序排列。(Z-A)
	 *
	 * 随后可以指定排序的类型：
	 * SORT_REGULAR - 默认。将每一项按常规顺序排列。
	 * SORT_NUMERIC - 将每一项按数字顺序排列。
	 * SORT_STRING  - 将每一项按字母顺序排列。
	 *
	 * @param array $array
	 * @param unknown $sortingOrder
	 * @param unknown $sortingType
	 */
	public static function multisort(array $array,$sortingOrder=SORT_ASC,$sortingType=SORT_STRING){
		return array_multisort($array);
	}
}
?>
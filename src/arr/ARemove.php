<?php
namespace qing\arr; 
/**
 * 移除数组键值或者值
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ARemove{
	/**
	 * 移除某个值
	 *
	 * @param array  $arr
	 * @param string $value
	 * @return array
	 */
	static public function value(array $arr,$value){
		$index=array_search($value,$arr);
		if($index!==false){
			//#找到值
			unset($arr[$index]);
		}
		return $arr;
	}
	/**
	 * 移除所有元素除了某个键值
	 *
	 * @param array  $arr
	 * @param string $key
	 * @return array
	 */
	static public function exclude(array $arr,$key){
		$newArr=[];
		if(isset($arr[$key])){
			$newArr[$key]=$arr[$key];
		}
		return $newArr;
	}
}
?>
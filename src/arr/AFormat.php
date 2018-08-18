<?php
namespace qing\arr; 
/**
 * 数组格式化
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class AFormat{
	/**
	 * 把某个键值的值作为索引键值
	 *
	 * @param array $arr
	 * @param string $key
	 */
	static public function idkey(array $arr,$key='id'){
		$new_array=[];
		foreach($arr as $row){
			$new_array[$row[$key]]=$row;
		}
		return $new_array;
	}
}
?>
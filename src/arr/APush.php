<?php
namespace qing\arr; 
/**
 * 数组插入数据
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class APush{
	/**
	 * 追加某个值/值如果存在则不插入
	 *
	 * @param array  $arr
	 * @param string $value
	 * @return array
	 */
	static public function unique(array $arr,$value){
		$index=array_search($value,$arr);
		if($index===false){
			//#没有找到值则插入
			$arr[]=$value;
		}
		return $arr;
	}
	/**
	 * 数组追加数组
	 * - 只用于数字索引数组
	 * - 如果是键值对，会丢失键值
	 *
	 * @param array $src
	 * @param array $new
	 * @return array
	 */
	static public function values(array $src,array $new){
		foreach($new as $v){
			$src[]=$v;
		}
		return $src;
	}	
}
?>
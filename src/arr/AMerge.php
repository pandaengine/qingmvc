<?php
namespace qing\arr; 
/**
 * 数组合并
 * 
 * @see array_merge_recursive
 * @see array_replace_recursive
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class AMerge{
	/**
	 * 移除所有元素除了某个键值
	 *
	 * +* | [*] | 所有
	 * -* | []  | 空
	 *
	 * @param array  $arr
	 * @param string $key ['+aaa','-bbb']['+*','-*']
	 * @return array
	 */
	static public function auto(array $arr1,array $arr2){
		foreach($arr2 as $value){
			$value=(string)$value;
			$sign =substr($value,0,1);
			if(in_array($sign,['+','-'])){
				//+/-
				$value=substr($value,1);
			}else{
				//#默认为+
				$sign ='+';
			}
			if($sign=='-'){
				//#减法
				if($value=='*'){
					//##清空所有|返回空
					$arr1=[];
				}else{
					//##移除值
					$arr1=ARemove::value($arr1,$value);
				}
			}else{
				//#加法
				if($value=='*'){
					//##追加所有|返回['*']
					return ['*'];
				}
				//##追加值
				$arr1=APush::unique($arr1,$value);
			}
		}
		return $arr1;
	}
}
?>
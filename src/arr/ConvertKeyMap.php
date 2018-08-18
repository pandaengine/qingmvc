<?php
namespace qing\arr;
/**
 * 两个数组转换键值映射
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ConvertKeyMap{
	/**
	 * src:
	 * - 每个元素可以是数组
	 * - 
	 * 
	 * @param array $src 每个值都必须是唯一的
	 * @param array $to ['','','']
	 */
	public static function keymap(array $src,array $to){
		$arr=[];
		$r=$c=0;
		foreach($src as $k=>$v){
			if(is_array($v)){
				//#数组
				foreach($v as $k2=>$v2){
					if(in_array($v2,$to)){
						//#值对应
						$idx=array_search($v2,$to);
						$arr[$idx]=[$k,$k2];
					}
				}
			}else{
				//#非数组
				if(in_array($v,$to)){
					//#值对应
					$idx=array_search($v,$to);
					$arr[$idx]=[$k];
				}
			}
		}
		//
		return $arr;
	}
	/**
	 * 
	 * @param array $keymap
	 * @param string $srcName
	 * @param string $toName
	 */
	public static function keymap_tostring(array $keymap,$srcName='srcArr',$toName='toArr'){
		$str='$'.$toName.'=[';
		$params=[];
		foreach($keymap as $k=>$keys){
			$s='';
			foreach($keys as $k2){
				if(is_string($k2)){
					$k2="'{$k2}'";
				}
				$s.="[$k2]";
			}
			$params[]='$'.$srcName.$s;
		}
		$str='$'.$toName.'=['.implode(',',$params).'];';
		return $str;
	}
	/**
	 * 每个值都赋予唯一的值
	 *
	 * @param array $to ['','','']
	 */
	public static function uniqueValues(array $arr){
		//#数组
		foreach($arr as $k=>$v){
			if(is_array($v)){
				$arr[$k]=self::uniqueValues($v);
			}else{
				$arr[$k]=md5(uniqid(mt_rand(),true));
			}
		}
		return $arr;
	}
}
?>
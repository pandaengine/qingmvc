<?php
namespace qing\arr; 
/**
 * 查找数组键或值
 * 
 * @see array_search
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ASearch{
	/**
	 * 加i不区分大小写
	 * - preg_match('/^(a|B|c)$/i','a');
	 * - stripos('|a|b|c|','|a|');
	 * - preg_grep
	 *
	 * @name Case insensitive
	 * @param string $need
	 * @param array $arr
	 * @return boolean
	 */
	public static function in($need,array $arr){
		$res=preg_grep("/^{$need}$/i", $arr);
		if($res){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 加i不区分大小写
	 * - preg_match('/^(a|B|c)$/i',$str);
	 * - stripos('|a|b|c|','|a|');
	 *
	 * @name Case insensitive
	 * @param string $need
	 * @param array $arr
	 * @return boolean
	 */
	public static function find($need,array $arr){
		$txt='|'.implode('|',$arr).'|';
		//#i：不区分大小写
		$res=stripos($txt,'|'.$need.'|');
		if($res===false){
			return false;
		}else{
			return true;
		}
	}
}
?>
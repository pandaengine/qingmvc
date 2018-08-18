<?php 
namespace qing\utils;
/**
 * 正则表达式
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0 all rights reserved.
 */
class RegExp{
	/**
	 * 格式化匹配模式
	 * 替换占位符
	 * ---
	 * \s空白字符
	 * \S非空白字符
	 * \d数字
	 * /s点号包括回车
	 * .*?非贪婪匹配
	 * 
	 * @param string $pattern 匹配模式规则
	 * @param bool   $catch   是否捕获占位符的数据返回|添加捕获子组小括号
	 * @return mixed
	 */
	public static function foramt($pattern,$catch=false,$canEmpty=false){
		if($canEmpty){
			//可以为空|量词|0,|1,
			$quantifier='*';
		}else{
			$quantifier='+';
		}
		$mapping=array(
		//任意类型字符|可以为空
		'[:any]'		=>'.'.$quantifier,
		//空白字符
		'[:blank]'		=>'\s'.$quantifier,
		//非空字符
		'[:nonblank]'	=>'\S'.$quantifier,
		//数字0-9	
		'[:num]'		=>'[0-9]'.$quantifier,
		//字符串字母/数字/_	
		'[:str]'		=>'[0-9a-zA-Z_\-]'.$quantifier
		);
		$replacement=array_values($mapping);
		if($catch){
			$replacement=array_map(function($v){
				return '('.$v.')';
			},$replacement);
		}
		$pattern=str_replace(array_keys($mapping),$replacement,$pattern);
		return $pattern;
	}
}
?>
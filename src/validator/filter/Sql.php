<?php
namespace qing\validator\filter;
/**
 * 行为扩展过滤器:处理sql组装字符|转义sql语句|过滤sql语句
 * escape|转义|f_safeSql
 * 
 * @tutorial 转义引号|转义字符|like通配符等字符
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Sql{
	/**
	 * 转义sql相关字符
	 * 避免sql注入
	 * 
	 * @param string $value
	 * @param string $like
	 * @return string
	 */
	public static function filter($value,$like=false){
		//转义特殊符号，' " \ NULL
		//$value=Escape::filter($value);
		$value=addslashes($value);
		if($like){
			$value=self::like($value);
		}
		return $value;
	}
	/**
	 * 转义sql like相关字符 '_' '%'
	 * 避免伪造查询
	 * 
	 * '_' 单个字符通配符
	 * '%' 多个字符通配符
	 * 
	 * addcslashes($value,'_%');
	 * 
	 * @param string $value
	 */
	public static function like($value){
		return addcslashes($value,'_%');
	}
}
?>
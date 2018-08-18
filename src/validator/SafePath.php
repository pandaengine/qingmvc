<?php
namespace qing\validator;
/**
 * 安全路径
 * 路径分隔符/\
 * 
 * \/:*?"<>|
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SafePath{
	/**
	 * @param string $value
	 * @param string $ds
	 * @return boolean
	 */
	static public function validate($value,$ds='/'){
		if($ds=='/'){
			//允许/，路径分割符
			$str=preg_quote('\:*?"<>|','/');
		}else{
			//允许\，路径分割符
			$str=preg_quote('/:*?"<>|','/');
		}
		return preg_match('/['.$str.']/',$value)==0;
	}
}
?>
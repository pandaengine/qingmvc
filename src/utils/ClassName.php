<?php
namespace qing\utils;
/**
 * 类名工具
 * 根据完整类名分割命名空间+短类名
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ClassName{
	/**
	 * 获取类命名空间+短类名
	 * \qing\model\Model=[\qing\model,Model]
	 *
	 * @param string $fullClassName 完整类名，包括命名空间
	 * @return [$namespace,$className]
	 */
	public static function format($fullClassName){
		if(($nsIndex=strrpos($fullClassName,'\\'))!==false){
			//存在命名空间
			$namespace=substr($fullClassName,0,$nsIndex);
			$className=substr($fullClassName,$nsIndex+1);
		}else{
			$namespace='';
			$className=$fullClassName;
		}
		return [$namespace,$className];
	}
	/**
	 * 只返回命名空间
	 *
	 * @param string $fullClassName
	 * @return string
	 */
	public static function onlyNamespace($fullClassName){
		$arr=static::format($fullClassName);
		return $arr[0];
	}
	/**
	 * 只返回类名，短类名
	 *
	 * @param string $fullClassName
	 * @return string
	 */
	public static function onlyName($fullClassName){
		$arr=static::format($fullClassName);
		return $arr[1];
	}
}
?>
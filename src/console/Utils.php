<?php
namespace qing\console;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Utils{
	/**
	 * @param string $fullClassName 完整类名，包括命名空间
	 * @return string
	 */
	public static function getShortClassName($fullClassName){
		if(($nsIndex=strrpos($fullClassName,'\\'))!==false){
			//存在命名空间
			return substr($fullClassName,$nsIndex+1);
		}
		return $fullClassName;
	}
	/**
	 * 把下划线转化为驼峰法
	 * 驼峰式大小写 外文名 Camel-Case，Camel Case，camel case
	 *
	 * @param string $field
	 * @return string
	 */
	public static function camelString($str){
		//#匹配所有的下划线，下划线后的第一个字母大写
		$str=preg_replace_callback('/\_([a-z])/i',function($value){
			return ucfirst($value[1]);
		},$str);
		return $str;
	}
	/**
	 * @param string $className
	 */
	public static function getClassName($className){
		//只允许字母数字下划线
		$className=preg_replace('/[^a-zA-Z0-9\_]/','',$className);
		//驼峰法
		$className=self::camelString($className);
		return ucfirst($className);
	}
	/**
	 * 方法名|把下划线转化为驼峰法
	 * setIs_like
	 * getIs_like
	 * is_like
	 * ucfirst($propName)
	 *
	 * @param string $field
	 * @param string $pre
	 * @return string
	 */
	public static function getMethodName($field,$pre=''){
		$field=self::camelString($field);
		return $pre.ucfirst($field);
	}
	/**
	 * 格式化过滤属性名称
	 * 不使用驼峰
	 *
	 * @param string $propName
	 */
	public static function getPropName($propName){
		//只允许字母数字下划线
		$propName=preg_replace('/[^a-zA-Z0-9\_]/','',$propName);
		//首字母只能是字母或下划线
		if(!preg_match('/^[a-z\_]/i', $propName)){
			return '_'.$propName;
		}
		return $propName;
	}
	/**
	 * 命名空间
	 *
	 * @param string $namespace
	 * @return string
	 */
	public static function getNamespace($namespace){
		if(!$namespace){
			return '';
		}else{
			$namespace=ltrim($namespace,'\\');
			return 'namespace '.$namespace.';';
		}
	}
}
?>
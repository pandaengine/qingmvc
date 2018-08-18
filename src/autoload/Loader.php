<?php
namespace qing\autoload;
/**
 * 类别名自动加载器
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Loader{
	/**
	 * 单例装载后的实例
	 * 
	 * @var array
	 */
	public static $_instances=array();
	/**
	 * 获取单例实例|简单的创建实例方法
	 *
	 * @param string|array 	$className  类名或包含类名和类文件的数组
	 * @return object
	 */
	public static function sgt($className=__CLASS__){
		if(isset(self::$_instances[$className])){
			return self::$_instances[$className];
		}else{
			return self::$_instances[$className]=new $className();
		}
	}
	/**
	 * 获取类命名空间+短类名
	 * \qing\mvc\model\Model=\qing\mvc\model+Model
	 * 应用未初始化，不能使用系统函数
	 * 
	 * @param string $fullClassName 完整类名，包括命名空间
	 * @return array($namespace,$className)
	 */
	public static function getClassNamespace($fullClassName){
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
	 * - 获取类名命名空间的第一段 
	 * - \qing\a\b\c -> qing |不包括 \
	 * - 无命名空间时返回空
	 * 
	 * @param string $fullClassName 完整类名，包括命名空间
	 * @return [$first,$other/子目录+类名]
	 */
	public static function getNSFirstPart($fullClassName){
		if(($nsIndex=strpos($fullClassName,'\\'))!==false){
			//#命名空间不为空
			$first=substr($fullClassName,0,$nsIndex);
			$other=substr($fullClassName,$nsIndex+1);
		}else{
			//#命名空间为空
			$first='';
			$other=$fullClassName;
		}
		return [$first,$other];
	}
}
?>
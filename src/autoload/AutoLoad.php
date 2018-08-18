<?php
namespace qing\autoload;
/**
 * 类别名自动加载器
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class AutoLoad{
	/**
	 * 类自动加载器
	 * psr0
	 * psr4
	 *
	 * @name autoload_psr4
	 * @see \qing\autoload\ClassLoader
	 * @param string $namespace 首部没有斜杠|qing\test\XXX
	 * @param string $path		目录路径
	 */
	public static function addNamespace($namespace,$path){
		/* @var $Q_composer \Composer\Autoload\ClassLoader */
		global $Q_composer;
		if($Q_composer!=null){
			//#composer
			$namespace=trim($namespace,'\\');
			$prefix=$namespace.'\\';
			$Q_composer->setPsr4($prefix,$path);
		}else{
			//#qingloader
			ClassLoader::sgt()->addNamespace($namespace,$path);
		}
	}
	/**
	 * 
	 * @param array $namespaces
	 */
	public static function addNamespaces(array $namespaces){
		foreach($namespaces as $ns=>$path){
			self::addNamespace($ns,$path);
		}
	}	
}
?>
<?php
namespace qing\filesystem;
/**
 * 导入include_path
 * 
 * set_include_path() - 设置 include_path 配置选项
 * get_include_path() - 获取当前的 include_path 配置选项
 * restore_include_path() - 还原 include_path 配置选项的值
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class IncludePath{
	/**
	 * 导入一个路径/目录
	 * 添加目录到php环境的 include_path
	 * set_include_path()
	 * ini_set('include_path','');
	 * ---
	 * set_include_path("./123");
	 * include("test1.php");   // ./123/test1.php
	 * ##只是帮助定位包含文件时的寻找路径，与类不存在自动导入无关
	 * ##把 $path 添加到了 现有的 include_path 的尾部
	 * 
	 * ---
	 * 
	 * - 只能作用于include
	 * - file_get_contents(,FILE_USE_INCLUDE_PATH) 参数FILE_USE_INCLUDE_PATH开启使用path
	 * 
	 * dump(is_file('index.php'));
	 * dump(file_get_contents('index.php'));
	 * //include 'index.php';
	 * 
	 */
	public static function set($path){
		$realpath=realpath($path);
		if(!$realpath){
			throw new \Exception("要导入的路径不存在[{$path}]");
		}
		//成功时返回旧的 include_path 或者在失败时返回 FALSE。
		$res=set_include_path(get_include_path().PATH_SEPARATOR.$realpath);
		if($res===false){
			throw new \Exception("导入目录失败[{$path}]");
		}
	}
	/**
	 * 获取include_path值
	 */
	public static function get(){
		$ini_include_paths=array_unique(explode(PATH_SEPARATOR,get_include_path())); //PHP默认的include path
		//把include数组中的点去掉;表示当前目录
		if(($index=array_search('.',$ini_include_paths,true))!==false){
			unset($ini_include_paths[$index]);
		}
		return $ini_include_paths;
		/*	
		//array_unshift() 函数在数组开头插入一个或多个元素。 插入$realpath
		//将导入的目录加入include path
		array_unshift(self::$ini_include_paths,$path);
		$res=set_include_path('.'.PATH_SEPARATOR.implode(PATH_SEPARATOR,self::$_includePaths));
		*/
	}
	/**
	 */
	public static function restore(){
		
	}
}
?>
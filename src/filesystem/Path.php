<?php
namespace qing\filesystem;
/**
 * path格式化
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Path{
	/**
	 * 目录分隔符格式化
	 * win: \
	 * linux: /
	 * 
	 * @param string $path
	 * @param string $ds
	 */
	public static function formatDS($path,$ds=DIRECTORY_SEPARATOR){
		//return preg_replace('/[\/\\\\]/',$ds,$path);
		if($ds=='\\'){
			return str_replace('/','\\',$path);
		}else{
			return str_replace('\\','/',$path);
		}
	}
	/**
	 * 路径包含中文时：默认dirname无法正确处理
	 * windows?
	 * windows包含中文的情况|dirname获取中文错误
	 * 
	 * @param string $filename
	 */
	public static function dirname($filename){
		//分隔符转换
		$filename=self::formatDS($filename,DS);
		$idx_r=strripos($filename,DS);
		return substr($filename,0,$idx_r);
	}
	/**
	 * @param string $filename
	 */
	public static function basename($filename){
		//分隔符转换
		$filename=self::formatDS($filename,DS);
		$idx_r=strripos($filename,DS);
		return substr($filename,$idx_r+1);
	}
	/**
	 * 截取相对路径
	 *
	 * @param string $path 绝对路径
	 * @param string $rootpath 根路径
	 * @return string
	 */
	public static function relativePath($path,$rootpath){
		$path    =self::formatDS($path,DS);
		$rootpath=self::formatDS($rootpath,DS);
		//截取
		$path=substr($path,strlen($rootpath));
		$path=trim($path,DS);
		return $path;
	}
}
?>
<?php
namespace qing\filesystem;
/**
 * 删除操作
 * 
 * - 目录
 * - 文件
 * 
 * @see rmdir 删除空目录  http://php.net/manual/zh/function.rmdir.php
 * @see unlink 删除文件  http://php.net/manual/zh/function.unlink.php
 * @name rm remove del
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0 all rights reserved.
 */
class RM{
	/**
	 * @param string $file
	 */
	public static function file($file){
		return unlink($file);
	}
	/**
	 * 删除空目录
	 *
	 * @param string  $dir
	 */
	public static function emptydir($dir){
		return rmdir($dir);
	}
	/**
	 * 删除空目录或非空目录
	 * - 递归删除
	 * - 删除目录下的文件或目录
	 *
	 * @param string  $dirname
	 */
	public static function dir($dirname){
		$dir=@opendir($dirname);
		if(!$dir){
			return false;
		}
		while(false!==($file=readdir($dir)) ){
			if($file=='.' || $file=='..'){
				continue;
			}
			$realfile=$dirname.DS.$file;
			if(is_dir($realfile)){
				//#目录，递归删除
				static::dir($realfile);
			}else{
				//#文件
				unlink($realfile);
			}
		}
		closedir($dir);
		//删除空目录
		rmdir($dirname);
		return true;
	}
}
?>
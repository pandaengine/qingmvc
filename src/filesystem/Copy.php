<?php
namespace qing\filesystem;
/**
 * 拷贝文件
 * 
 * - 没有拷贝目录的说法
 * - 目标目录不存在则创建即可
 * 
 * @name CP copy
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Copy{
	/**
	 * 拷贝文件
	 *
	 * @param string $src
	 * @param string $dest
	 * @return boolean
	 */
	public static function file($src,$dest){
		//创建目录
		MK::dir(dirname($dest));
		if(!copy($src,$dest)){
			throw new \Exception('copyFile failed! '.$src.'->'.$dest);
		}
		return true;
	}
	/**
	 * 递归拷贝目录
	 * 
	 * @param string $src
	 * @param string $dest
	 * @return boolean
	 */
	public static function dir($src,$dest){
		MK::dir(dirname($dest));
		//扫描目录
		foreach(scandir($src) as $file){
			if($file=='.' || $file=='..'){
				continue;
			}
			$realfile=$src.DS.$file;
			$destfile =$dest.DS.$file;
			//
			if(is_dir($realfile)){
				//#目录，递归复制
				self::dir($realfile,$destfile);
			}else{
				//#文件
				self::file($realfile,$destfile);
			}
		}
		return true;
	}
}
?>
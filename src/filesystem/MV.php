<?php
namespace qing\filesystem;
/**
 * 移动文件
 * - 使用重命名来实现移动,如果要移动文件的话，请使用 rename() 函数
 * 
 * rename - 重命名一个文件或目录
 * 
 * // 将folder文件夹移动到folder2文件夹中，并重命名为folder3文件夹
 * $state = rename('folder','folder2/folder3');
 * 
 * @name MV move rename
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MV{
	/**
	 * 移动文件
	 * 
	 * @param string $src
	 * @param string $dest
	 * @return boolean
	 */
	public static function file($src,$dest){
		return rename($src,$dest);
	}
	/**
	 * 递归移动目录
	 * 
	 * @param string $src
	 * @param string $dest
	 * @return boolean
	 */
	public static function dir($src,$dest){
		//扫描目录
		foreach(scandir($src) as $file){
			if($file=='.' || $file=='..'){
				continue;
			}
			$realfile=$src.DS.$file;
			$distfile=$dest.DS.$file;
			//
			if(is_dir($realfile)){
				//#目录，递归移动
				self::dir($realfile,$distfile);
			}else{
				//#文件
				self::file($realfile,$distfile);
			}
		}
		return true;
	}
}
?>
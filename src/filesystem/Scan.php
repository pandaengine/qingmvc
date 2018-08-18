<?php
namespace qing\filesystem;
/**
 * 扫描目录
 * 
 * - 目录
 * - 文件
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0 all rights reserved.
 */
class Scan{
	/**
	 * 扫描获取某个目录下的文件列表|不包括目录
	 *
	 * @param string  $dirname
	 * @param string  $filter 过滤器|后缀过滤| /\.php$/i
	 * @return array
	 */
	public static function files($dirname,$filter=''){
		$files=[];
		foreach(scandir($dirname) as $k=>$file){
			//#是目录/不符合文件名规则
			if($file=='.' || $file=='..'){
				continue;
			}
			$realfile=$dirname.DS.$file;
			if(is_file($realfile)){
				if($filter>'' && !preg_match($filter,$file)){
					//#过滤文件名|跳过文件
					continue;
				}
				$files[]=$file;
			}
		}
		return $files;
	}
	/**
	 * @param string $dirname
	 */
	public static function dirs($dirname){
		list($files,$dirs)=static::filesDirs($dirname);
		return $dirs;
	}
	/**
	 * 扫描获取某个目录下的文件列表
	 * #不需要过滤器，目录和文件混合无法过滤
	 *
	 * list($files,$dirs)=filesDirs($dirname);
	 *
	 * @name childs
	 * @param string  $dirname
	 * @return array
	 */
	public static function filesDirs($dirname){
		$dirs =[];
		$files=[];
		foreach(scandir($dirname) as $k=>$file){
			//#是目录/不符合文件名规则
			if($file=='.' || $file=='..'){
				continue;
			}
			$realfile=$dirname.DS.$file;
			//
			if(is_dir($realfile)){
				$dirs[]=$file;
			}else{
				$files[]=$file;
			}
		}
		return [$files,$dirs];
	}
}
?>
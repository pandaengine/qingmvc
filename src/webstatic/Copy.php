<?php
namespace qing\webstatic;
use qing\filesystem\Copy;
use qing\exceptions\NotfoundFileException;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Copy{
	/**
	 * @param sreing $listFile
	 * @param sreing $cachePath
	 * @return boolean
	 */
	static public function format($listFile,$cachePath){
		$rootDir=dirname($listFile);
		$files=Utils::parseFilelist($listFile,false);
		//
		foreach($files as $file){
			//$file为相对路径，目录或文件
			$realFile =$rootDir.DS.$file;
			$cacheFile=$cachePath.DS.$file;
			//
			if(is_dir($realFile)){
				//#目录
				Copy::dir($realFile,$cacheFile);
				
			}elseif(is_file($realFile)){
				//#文件
				Copy::file($realFile,$cacheFile);
				
			}else{
				throw new NotfoundFileException($realFile);
			}
		}
	}
}
?>
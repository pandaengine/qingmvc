<?php
namespace qing\webstatic;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Utils{
	/**
	 * 合并js或css文件
	 *
	 * @param array $files
	 * @param boolean $debug
	 * @return string
	 */
	static public function mergeFile(array $files,$debug=false){
		$content ='';
		$fileList=[];
		foreach($files as $file){
			$tmp="";
			if(!is_file($file)){
				//文件不存在
				continue;
			}
			if($debug){
				$tmp.="\n\n/*\n++++++++++++++++++++++++++++++++++++++++\n";
				$tmp.="+ FILE:".$file."";
				$tmp.="\n++++++++++++++++++++++++++++++++++++++++\n*/\n\n";
				//#文件列表
				$fileList[]=$file;
			}
			$tmp.=file_get_contents($file);
			$content.=$tmp;
		}
		$listTip='';
		if($debug){
			$listTip.="/** \n";
			$listTip.="导入的文件列表:\n\n";
			$listTip.=implode("\n",$fileList);
			$listTip.="\n*/\n\n";
		}
		return $listTip.$content;
	}
	/**
	 * 解析filelist文件
	 *
	 * @param string $filename
	 * @param boolean $realpath
	 * @return array
	 */
	static public function parseFilelist($filename,$realpath=true){
		$dirname=dirname($filename);
		$filedir='';
		if($realpath){$filedir=$dirname.DS;}
		//
		$lines=\qing\filesystem\FileLines::filelines($filename);
		$_lines=[];
		foreach($lines as $line){
			$line=trim($line);
			//注释/#abc.js
			if($line=='' || preg_match('/^#/',$line)>0){
				//空或者#开头注释跳过
				continue;
			}
			//包含/@include ../jsng/filelist
			if(preg_match('/^\@include\s+(.*)/',$line,$matches)>0){
				$includeFile=$matches[1];
				$includeFile=trim($includeFile,'"\'');
				$includeFile=realpath($dirname.DS.$includeFile);
				if(!$includeFile){
					throw new \qing\exceptions\NotfoundFileException($dirname.DS.$includeFile);
				}
				//解析包含的
				$_files2=self::parseFilelist($includeFile,$realpath);
				foreach($_files2 as $_file2){
					$_lines[]=$_file2;
				}
				continue;
			}
			$_lines[]=$filedir.$line;
		}
		return $_lines;
	}
}
?>
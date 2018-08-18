<?php
namespace qing\filesystem;
/**
 * 文件帮助类
 * 数据缓存到php数组，php文件
 * -------------------------------------------------------
 * put:	$newFile?file_put_contents($file, $content_2):file_put_contents($file, $content_2,FILE_APPEND);
 * get:	file_get_contents();
 * -------------------------------------------------------
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0 all rights reserved.
 */
class File{
	/**
	 * 保存内容到文件，包括数组
	 * file_put_contents($file, $content_2,FILE_APPEND)
	 * 
	 * @param $content 保存内容
	 * @param $filename 文件名
	 * @param $newFile 是否创建新文件
	 */
	public static function put($content,$filename,$newFile=true){
		if(!is_dir(dirname($filename))){
			mkdir(dirname($filename),0755,true);
		}
		if(is_array($content)){
			$content=var_export($content,true);
			$content="<?php\n return {$content};\n?>";
		}
		// w 只写。打开并清空文件的内容；如果文件不存在，则创建新文件。
		// $fp=fopen($filename,"w") or throw_exception("写入文件失败！[{$filename}]");
		// fwrite($fp,$content);
		// fclose($fp);
		$newFile?file_put_contents($filename,$content):file_put_contents($filename,$content,FILE_APPEND);
	}
	/**
	 * 获取 包含数组
	 */
	public static function get($filename){
		if(is_file($filename)){
			return include $filename;
		}else{
			return false;
		}
	}
	/**
	 * 取得文件的后缀
	 * admin.html admin.css
	 * a.b.c.css
	 */
	public static function getExt($filename){
		$pathinfo=pathinfo($filename);
		return strtolower($pathinfo['extension']);
	}
}
?>
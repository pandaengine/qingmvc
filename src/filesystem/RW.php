<?php
namespace qing\filesystem;
/**
 * 读取文件
 * read and write
 * 

fopen — 打开文件或者 URL
fputs — fwrite 的别名
fread — 读取文件（可安全用于二进制文件）
fscanf — 从文件中格式化输入
fwrite — 写入文件（可安全用于二进制文件）

 * @name RW readwrite
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class RW{
	/**
	 * fread() 从文件指针 handle 读取最多 length 个字节。 
	 * 打开文件->读取->关闭
	 * 
	 * 该函数在遇上以下几种情况时停止读取文件：
	 * - 读取了 length 个字节
	 * - 到达了文件末尾（EOF）
	 * 
	 * @param string $filename
	 * @param number $length
	 */
	public static function read($filename,$length=0){
		$fp=fopen($filename, "r");
		if($length>0){
			$content=fread($fp,$length);
		}else{
			//$content=fread($handle,filesize($filename));
			$content=fread($fp);
		}
		fclose($fp);
		return $content;
	}
	/**
	 * 打开->写入->关闭
	 *
	 * @param string $filename
	 * @return string
	 */
	public static function write($filename,$content){
		$fp=fopen($filename,'w');
		fwrite($fp,$content);
		fclose($fp);
	}
	/**
	 * @param string $filename
	 * @return string
	 */
	public static function get($filename){
		return file_get_contents($filename);
	}
	/**
	 * file_put_contents($filename,$content,FILE_APPEND | LOCK_EX)
	 * 
	 * Flag						|描述
	 * -------------------------|---------------------
	 * FILE_USE_INCLUDE_PATH	|在 include 目录里搜索 filename。 更多信息可参见 include_path。
	 * FILE_APPEND				|如果文件 filename 已经存在，追加数据而不是覆盖。
	 * LOCK_EX					|在写入时**获得一个独占锁**。
	 * 
	 * @param string $filename
	 * @param string $content
	 * @param string $flags
	 * @return number
	 */
	public static function put($filename,$content,$flags=null){
		return file_put_contents($filename,$content,$flags);
	}
}
?>
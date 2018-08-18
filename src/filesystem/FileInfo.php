<?php
namespace qing\filesystem;
/**
 * 

fileatime — 取得文件的上次访问时间
filectime — 取得文件的 inode 修改时间
filegroup — 取得文件的组
fileinode — 取得文件的 inode
filemtime — 取得文件修改时间
fileowner — 取得文件的所有者
fileperms — 取得文件的权限

dirname();
basename();

filesize — 取得文件大小/bytes
filetype — 取得文件类型/返回文件的类型/可能的值有 fifo，char，dir，block，link，file 和 unknown。

stat — 给出文件的信息
lstat — 给出一个文件或符号连接的信息. lstat() 和 stat() 相同，只除了它会返回符号连接的状态
fstat — 通过已打开的文件指针取得文件信息


 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FileInfo{
	/**
	 * 文件后缀
	 *
	 * dirname($filename);
	 * bashname($filename);
	 *
	 * @param string $filename
	 * @return string
	 */
	public static function ext($filename){
		$pathinfo=pathinfo($filename);
		return $pathinfo['extension'];
	}
	/**
	 * 文件名称
	 *
	 * @param string $filename
	 * @return string
	 */
	public static function name($filename){
		$pathinfo=pathinfo($filename);
		return $pathinfo['filename'];
	}
	/**
	 * filemtime — 取得文件修改时间
	 * 
	 * @link http://php.net/manual/zh/function.filemtime.php
	 * @param string $filename
	 * @return string
	 */
	public static function mtime($filename){
		return filemtime($filename);
	}
}
?>
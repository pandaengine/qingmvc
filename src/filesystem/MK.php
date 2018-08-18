<?php
namespace qing\filesystem;
/**
 * 创建目录
 * 创建文件
 * 
 * mkdir - 新建目录
 * touch - 设定文件的访问和修改时间，不存在则创建
 * 
 * @name Make mk
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MK{
	/**
	 * mkdir — Makes directory
	 * 文件：0644 | 文件夹：0755
	 *
	 * makedir('',0644,true)
	 * @name makedir
	 * @param string $dirname
	 * @param number $mode 		 默认是0777/在 Windows 下被忽略。|0744|0644
	 * @param string $recursive 递归生成各级目录
	 */
	public static function dir($dirname,$mode=MOD_DIR,$recursive=true){
		if(!is_dir($dirname)){
			if(!mkdir($dirname,$mode,$recursive)){
				throw new \Exception('makedir failed! '.$dirname);
			}
		}
		return true;
	}
	/**
	 * 尝试将由 filename 给出的文件的访问和修改时间设定为给出的 time。
	 * 注意访问时间总是会被修改的，不论有几个参数。
	 * 如果文件不存在，则会被创建。
	 * 
	 * @param string $filename
	 * @return boolean
	 */
	public static function file($filename){
		return touch($filename);
	}
}
?>
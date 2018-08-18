<?php 
namespace qing\lock;
/**
 * LOCK_EX | LOCK_NB
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FileLock{
	/**
	 * 读时，使用共享锁
	 * 
	 * @param string $filename
	 * @param string $operation
	 * @return string
	 */
	static public function read($filename,$operation=LOCK_SH){
		$pfile=fopen($filename,"r");
		//排它性的锁定
		if(flock($pfile,$operation)){
			//#锁定
			$content=fread($pfile,filesize($filename));
			//#解锁
			flock($pfile,LOCK_UN);
			fclose($pfile);
			return $content;
		}
		return '';
	}
	/**
	 * 写时，使用排它锁
	 * 
	 * @name append a+
	 * @param string $filename
	 * @param string $content
	 * @param string $operation
	 * @return boolean
	 */
	static public function write($filename,$content,$operation=LOCK_EX){
		$pfile=fopen($filename,"w+");
		//排它性的锁定
		if(flock($pfile,$operation)){
			//写数据时，文件被锁定，不能读取和写入？
			fwrite($pfile,$content);
			//释放锁
			flock($pfile,LOCK_UN);
			fclose($pfile);
			return true;
		}
		return false;
	}
	/**
	 * @param string $filename
	 * @param string $mode r/r+/w/w+/a/a+
	 * @param string $operation
	 * @return boolean
	 */
	static public function lock($filename,$mode='r',$operation=LOCK_EX){
		$pfile=fopen($filename,"w+");
		//排它性的锁定
		if(!flock($pfile,$operation)){
			 
		}
		return $pfile;
	}
	/**
	 * 对先前取得的锁实例进行解锁
	 * 
	 * @param 文件资源指针 $pfile
	 */
	static public function unlock($pfile){
		flock($pfile,LOCK_UN);
		fclose($pfile);
	}
}
?>
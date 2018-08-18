<?php 
namespace qing\filesystem;
/**
 * LOCK_EX | LOCK_NB
 * 

LOCK_SH 取得共享锁定（读取的程序）
LOCK_EX 取得独占锁定（写入的程序）
LOCK_UN 释放锁定（无论共享或独占）
LOCK_NB 如果不希望 flock() 在锁定时堵塞，则是 LOCK_NB（Windows 上还不支持）。

flock($fp, LOCK_EX | LOCK_NB)

 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Lock{
	/**
	 * 读时，使用共享锁
	 * 
	 * @param string $filename
	 * @param string $operation
	 * @return string
	 */
	static public function read($filename,$operation=LOCK_SH){
		$fp=fopen($filename,"r");
		//锁定
		if(flock($fp,$operation)){
			//#锁定
			$content=fread($fp,filesize($filename));
			//#解锁
			flock($fp,LOCK_UN);
		}else{
			$content='';
		}
		fclose($fp);
		return $content;
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
		$fp=fopen($filename,"w+");
		//排它性的锁定
		if(flock($fp,$operation)){
			//写数据时，文件被锁定，不能读取和写入？
			fwrite($fp,$content);
			//释放锁
			flock($fp,LOCK_UN);
			$res=true;
		}else{
			$res=false;
		}
		fclose($fp);
		return $res;
	}
	/**
	 * @param string $filename
	 * @param string $mode r/r+/w/w+/a/a+
	 * @param string $operation
	 * @return boolean
	 */
	static public function getlock($filename,$mode='r',$operation=LOCK_EX){
		$fp=fopen($filename,"w+");
		//获取锁定
		if(flock($fp,$operation)){
			//获取锁成功
			//释放锁
			flock($fp,LOCK_UN);
		}else{
			//获取锁失败
		}
		//fclose($fp);
		return $fp;
	}
	/**
	 * 对先前取得的锁实例进行解锁
	 * 
	 * @param 文件资源指针 $fp
	 */
	static public function unlock($fp){
		flock($fp,LOCK_UN);
		fclose($fp);
	}
}
?>
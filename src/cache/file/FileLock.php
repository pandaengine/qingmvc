<?php
namespace qing\cache\file;
/**
 * 读取和写入时锁定，保证数据一致性
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FileLock extends FileCache{
	/**
	 * @param $key=filename 要取出的文件名
	 * @see \qing\cache\Cache::get()
	 */
	public function get($key){
		$filename=$this->getCacheFile($key);
		if(!is_file($filename)){
			//值不存在返回false
			return false;
		}
		$fp=fopen($filename,'r');
		if($fp){
			//#读取时获取共享锁|其他线程可读但不可写
			flock($fp,LOCK_SH);
			//#include获取锁？
			$value=include $filename;
			//#释放锁
			flock($fp,LOCK_UN);
			fclose($fp);
			return $this->decodeValue($value,$filename);
		}else{
			return '';
		}
	}
}
?>
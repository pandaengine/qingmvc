<?php
namespace qing\cache\file;
use qing\cache\Cache;
use qing\filesystem\MK;
/**
 * File 缓存驱动
 * host为缓存目录|一个键值对应一个缓存文件
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FileCache extends Cache{
	/**
	 * 缓存文件目录
	 *
	 * @name cacheDir
	 * @var string
	 */
	public $host='';
	/**
	 * 写入时的锁类型
	 * LOCK_EX 独占锁
	 * 
	 * @var number
	 */
	public $lockMode=LOCK_EX;
	/**
	 * 编码要保存的数据|把过期时间等数据信息也缓存
	 *
	 * @param string $value	   数据值
	 * @param string $expire 过期时间/秒
	 * @return return string
	 */
	protected function encodeValue($value,$expire){
		//数据信息|过期时间等等|总是以数组存储
		$encodeValue=array();
		$encodeValue['expire'] =(int)$expire;
		$encodeValue['addtime']=time();
		$encodeValue['value']  =$value;
		$content=var_export($encodeValue,true);
		$content="<?php\n return ".$content.";\n?>";
		return $content;
	}
	/**
	 * 解码数据
	 * filemtime|文件修改时间
	 *
	 * @param string $encodeValue 	已编码的数据
	 * @param string $filename		缓存文件
	 * @return return string
	 */
	protected function decodeValue($encodeValue,$filename){
		if(!is_array($encodeValue)){
			return false;
		}
		$expire =(int)$encodeValue['expire'];
		$value =$encodeValue['value'];
		if($expire===0){
			//不限制有效时间|直接返回
			return $value;
		}
		$addtime=(int)$encodeValue['addtime'];
		//$addtime=filemtime($filename);
		if(time()>($addtime+$expire)){
			//缓存已经过期|返回false
			//当前时间>文件修改时间/上一次缓存时间+有效时间
			return false;
		}
		return $value;
	}
	/**
	 * 取得缓存文件名
	 */
	protected function getCacheFile($key){
		return $this->host.DS.$this->prefix.$key.PHP_EXT;
	}
	/**
	 * 链接初始化|连接操作
	 * 创建缓存文件目录
	 */
	protected function connect(){
		//缓存文件目录
		if(!$this->host){
			//#默认目录
			$this->host=APP_RUNTIME.DS.'~cache.file';
		}
		MK::dir($this->host);
		$this->host=realpath($this->host);
		return null;
	}
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
		$value=include $filename;
		return $this->decodeValue($value,$filename);
	}
	/**
	 * 写入缓存|一个文件对应一个键值数据
	 * 
	 * @param $key 	       要存入的文件名
	 * @param $value  要存入的数据|string|int|array
	 * @param $expire 过期时间|有效期秒|60s|60s之后过期
	 */
	public function set($key,$value,$expire=0){
		$filename=$this->getCacheFile($key);
		//编码数据
		$value=$this->encodeValue($value,$expire);
		try{
			//#先创建子目录
			MK::dir(dirname($filename));
			/*
			//w只写。打开并清空文件的内容；如果文件不存在，则创建新文件。
			$fp=fopen($filename,"w");
			//fwrite是原子性的？一次写入则可以保证数据一致性？
			fwrite($fp,$value);
			fclose($fp);
			*/
			//LOCK_EX在写入时获得一个独占锁。|其他线程不可读也不可写|避免读到脏数据
			file_put_contents($filename,$value,$this->lockMode);
			
		}catch (\Exception $e){
			throw $e;
		}
		return true;
	}
	/**
	 * 删除对应文件
	 * @param $key 键值
	 */
	public function delete($key){
		$filename=$this->getCacheFile($key);
		if(is_file($filename)){
			return unlink($filename);
		}else{
			return false;
		}
	}
	/**
	 * 清除所有文件
	 * 
	 * @see \qing\cache\Cache ::clear()
	 */
	public function clear(){
		//链接初始化
		$cacheDir=$this->host;
		foreach (scandir($cacheDir) as $k=>$v){
			$fileName=$cacheDir.DS.$v;
			if(!is_file($fileName)){//包括 . ..
				continue;
			}
			if(!unlink($fileName)){
				return false;
			}
		}
		return true;
	}
	/**
	 * 获取所有数据
	 * 
	 * @see \qing\cache\Cache::getAll()
	 */
	public function getAll(){
		$cacheDir=$this->cacheDir;
		$data=array();
		foreach (scandir($cacheDir) as $file){
			if(in_array($file,['.','..'])){//包括 . ..
				continue;
			}
			$key=substr($file,0,-4);
			$data[$key]=$this->get($key);
		}
		return $data;
	}
}
?>
<?php
namespace qing\cache\memcache;
use qing\cache\Cache;
/**
 * Memcache 缓存驱动
 *
 * @property $conn \Memcache
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MemcacheCache extends Cache{
	/**
	 * 连接操作
	 * $memcache->addserver($host)
	 * 
	 * @return \Memcache
	 * @see \qing\cache\Cache::connect()
	 */
	protected function connect(){
		$memcache=new \Memcache();
		if($this->pconnect){
			//长连接
			$func='pconnect';
		}else{
			$func='connect';
		}
		if($this->timeout>0){
			$res=$memcache->$func($this->host,$this->port,$this->timeout);
		}else{
			$res=$memcache->$func($this->host,$this->port);
		}
		if(!$res){throw new \Exception('Memcache connect failed');}
		return $memcache;
	}
	/**
	 *
	 * @see \qing\cache\Cache::get()
	 */
	public function get($key){
		$key=$this->getKey($key);
		return $this->conn->get($key);
	}
	/**
	 * 1.$compress = is_bool($value) || is_int($value) || is_float($value) ? false : MEMCACHE_COMPRESSED;
	 * 2.set($key,$value,$compress,$expire);
	 *
	 * @param $key 键值
	 * @param $value 值
	 * @param $expire 失效时间。如果此值设置为0表明此数据永不过期
	 */
	public function set($key,$value,$expire=0){
		$key=$this->getKey($key);
		$compress=false;
		$expire  =(int)$expire;
		if($expire===0){
			return $this->conn->set($key,$value,$compress);
		}else{
			return $this->conn->set($key,$value,$compress,$expire);
		}
	}
	/**
	 *
	 * @param $key 键值
	 * @param $expire 删除该元素的执行时间
	 */
	public function delete($key,$expire=false){
		$key=$this->getKey($key);
		if($expire){
			return $this->conn->delete($key);
		}else{
			return $this->conn->delete($key,$expire);
		}
	}
	/**
	 * 清除缓存
	 */
	public function clear(){
		return $this->conn->flush();
	}
	/**
	 * 关闭链接
	 * 
	 * @see \qing\cache\Cache::close()
	 */
	public function close(){
		if($this->conn){
			//避免关闭多次
			$this->conn->close();
			$this->conn=null;
		}
	}
	/**
	 * 获取所有数据
	 * 
	 * @see \qing\cache\Cache ::getAll()
	 */
	public function getAll(){
		$memcache=$this->conn;
		$list=array();
		$allSlabs=$memcache->getExtendedStats('slabs');
		// $items = $memcache->getExtendedStats('items');
		foreach($allSlabs as $server=>$slabs){
			foreach($slabs as $slabId=>$slabMeta){
				if(in_array($slabId,array("active_slabs","total_malloced"))) continue;
				$cdump=$memcache->getExtendedStats('cachedump',(int)$slabId);
				foreach($cdump as $keys=>$arrVal){
					/*
					 * $keys : host:port localhost:11211 $arrVal:
					 */
					foreach($arrVal as $k=>$v){
						$data[$k]=$memcache->get($k);
					}
				}
			}
		}
		return $data;
	}
}
?>
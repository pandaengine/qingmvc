<?php
namespace qing\cache\redis;
use qing\cache\Cache;
/**
 * Redis 缓存驱动
 *
 * @property $conn \Redis
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class RedisCache extends Cache{
	/**
	 * 密码
	 *
	 * @var string
	 */
	public $pwd='';
	/**
	 * 数据库
	 * 那么，redis有没有什么方法使不同的应用程序数据彼此分开同时又存储在相同的实例上呢？
	 * 
	 * 就相当于mysql数据库，不同的应用程序数据存储在不同的数据库下。
	 * 
	 * redis下，数据库是由一个整数索引标识，而不是由一个数据库名称。默认情况下，一个客户端连接到数据库0
	 * select 2 切换到数据库2
	 *
	 * @var string
	 */
	public $database=0;
	/**
	 * 连接操作
	 * socket:resource(46) of type (Redis Socket Buffer)
	 *
	 * @see \qing\cache\Cache ::connect()
	 * @return \Redis
	 */
	protected function connect(){
		$redis=new \Redis();
		//$res返回true/false
		if($this->pconnect){
			//长连接
			$res=$redis->pconnect($this->host,$this->port,$this->timeout);
		}else{
			$res=$redis->connect($this->host,$this->port,$this->timeout);
		}
		//pwd
		if($this->pwd>''){
			$redis->auth($this->pwd);
		}
		if(0!=$this->database){
			$redis->select($this->database);
		}
		if(!$res){throw new \Exception('Redis连接失败');}
		return $redis;
	}
	/**
	 * 取得缓存
	 * 
	 * @see \qing\cache\Cache::get()
	 */
	public function get($key){
		$key=$this->getKey($key);
		return $this->conn->get($key);
	}
	/**
	 * 写入缓存
	 * 
	 * @access public
	 * @param string $name 缓存变量名
	 * @param mixed $value 存储数据
	 * @param integer $expire 有效时间（秒）
	 * @return boolean
	 */
	public function set($key,$value,$expire=0){
		$key=$this->getKey($key);
		if($expire>0){
			//设置当前键值的有效期
			$res=$this->conn->setex($key,$expire,$value);
		}else{
			$res=$this->conn->set($key,$value);
		}
		return $res;
	}
	/**
	 * 删除数据
	 * 
	 * @param $key 键值
	 */
	public function delete($key){
		$key=$this->getKey($key);
		return $this->conn->delete($key);
	}
	/**
	 * 清除数据
	 * 
	 * @see \qing\cache\Cache::clear()
	 */
	public function clear(){
		return $this->conn->flushDB();
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
	 * @see \qing\cache\Cache::getAll()
	 * @return array
	 */
	public function getAll(){
		$keys=$this->conn->keys("*");
		$data=array();
		foreach($keys as $key){
			$data[$key]=$this->get($key);
		}
		return $data;
	}
}
?>
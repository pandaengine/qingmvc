<?php
namespace qing\cache;
use qing\com\Component;
/**
 * 缓存驱动 基类
 * 1. 高速缓存 Memcache/Redis
 * 2. 文件缓存 File
 * 3. 数据库缓存 Sqlite/MongoDb
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
abstract class Cache extends Component implements CacheInterface{
	/**
	 * 服务器地址
	 *
	 * @example 127.0.0.1
	 * @var string
	 */
	public $host='127.0.0.1';
	/**
	 * 服务器端口
	 *
	 * @example 
	 * - redis 6379 
	 * - Memcache 11211
	 * - Memcached 11211
	 * @var string
	 */
	public $port=6379;
	/**
	 * 连接持续时间|超时时间|单位秒。
	 *
	 * @var string
	 */
	public $expire=0;
	/**
	 * #Memcache
	 * 连接持续（超时）时间，单位秒。
	 * 默认值1秒，修改此值之前请三思，过长的连接持续时间可能会导致失去所有的缓存优势。
	 *
	 * @var string
	 */
	public $timeout=0;
	/**
	 * 键值前缀
	 *
	 * @var string
	 */
	public $prefix='';
	/**
	 * 数据编码
	 *
	 * @var string
	 */
	public $charset='utf8';
	/**
	 * 持久化长连接
	 * persistent connection
	 *
	 * @var string
	 */
	public $pconnect=false;
	/**
	 * 错误信息
	 * 
	 * @var string
	 */
	protected $error='';
	/**
	 * 链接对象
	 *
	 * @name $connection
	 */
	protected $conn;
	/**
	 * 组件初始化
	 * 初始化cache链接
	 *
	 * @see \qing\com\Component::initComponent()
	 */
	public function initComponent(){
		$this->conn=$this->connect();
	}
	/**
	 * 析构方法
	 *
	 * @access public
	 */
	public function __destruct(){
		if($this->conn){
			// 关闭连接
			$this->close();
		}
	}
	/**
	 * 获取数据键值
	 * 
	 * @param string $key
	 * @return string
	 */
	public function getKey($key){
		return $this->prefix.$key;
	}
	/**
	 * 获取链接错误
	 */
	public function getError(){
		return $this->error;
	}
	/**
	 * 取得所有数据|一般只用于测试时使用
	 * 
	 * @throws \Exception
	 */
	public function getAll(){
		//缓存驱动getAll方法未实现
		throw new \Exception(L()->class_method_notfound.' getAll ');
	}
	/**
	 * 连接数据
	 * 链接初始化
	 * 
	 * @access protected 不能被外界直接调用
	 * @return null
	 */
	protected function connect(){}
	/**
	 * 关闭链接
	 *
	 * @access protected 不能被外界直接调用
	 * @access public 2018
	 * @return null
	 */
	public function close(){}
	/**
	 * 根据键值，取得数据
	 * 
	 * @param string $key
	 */
	abstract public function get($key);
	/**
	 * 写入数据|并设置有效日期
	 *
	 * @access public
	 * @param string  $name 缓存变量名
	 * @param mixed   $value 存储数据
	 * @param integer $expire 有效时间（秒）|失效时间|0:则不限制过期时间
	 * @return boolean
	 */
	abstract public function set($key,$value,$expire=0);
	/**
	 * 插入数据|并设置有效日期
	 * 
	 * @param string $key
	 * @param string $value
	 * @param number $expire
	 * @throws \Exception
	 */
	public function setex($key,$value,$expire=0){
		//#缓存驱动setex方法未实现
		throw new \Exception(L()->class_method_notfound.' '.__FUNCTION__);
	}
	/**
	 * 删除数据
	 * 
	 * @param string $key
	 */
	abstract public function delete($key);
	/**
	 * 清空数据
	 */
	abstract public function clear();
	/**
	 * 获取数据|如果没有则设置
	 *
	 * @deprecated 
	 * @param string $key
	 * @param string $value
	 * @param number $expire
	 */
	/*
	public function getAndSet($key,\Closure $setter,$expire=0){
		$data=$this->get($key);
		if($data!==false){
			//#直接返回缓存
			return $data;
		}
		//#重新缓存数据并返回
		$data=call_user_func($setter);
		$this->set($key,$data,$expire);
		return $data;
	}
	*/
}
?>
<?php
namespace qing\cache\redis;
/**
 * Redis 缓存驱动
 * 
 * # 支持复杂数据
 * - 数组
 * 
 * @property $conn \Redis
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class RedisArray extends RedisCache{
	/**
	 * 编码数据
	 * 只编码数据
	 * 
	 * @see json_encode($value)/serialize($value)
	 * @param string $value
	 * @return return string
	 */
	protected function encodeValue($value){
		if(is_array($value)){
			$value='J@'.json_encode($value,JSON_UNESCAPED_UNICODE);
		}
		return $value;
	}
	/**
	 * 解码取得的数据|编码非字符串/整型类型数据
	 * 
	 * @see json_decode($value,true)/unserialize($value)
	 * @param string $value
	 * @return return string
	 */
	protected function decodeValue($value){
		//布尔值|false查询失败
		if(is_bool($value)){
			//键不存在
			return $value;
		}elseif(substr($value,0,2)=='J@'){
			//json解码
			$value=substr($value,2);
			$value=json_decode($value,true);
			//json_decode解码失败|直接返回
			//is_null($value) && $value=$value;
			return $value;
		}else{
			return $value;
		}
	}
	/**
	 * 取得缓存
	 * 
	 * @see \qing\cache\Cache::get()
	 */
	public function get($key){
		return $this->decodeValue(parent::get($key));
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
		$value=$this->encodeValue($value);
		return parent::set($key,$value,$expire);
	}
}
?>
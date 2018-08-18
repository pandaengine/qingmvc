<?php 
namespace qing\cache;
/**
 * Cache配置
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface CacheInterface{
	/**
	 * 根据键值，取得数据
	 *
	 * @param string $key
	*/
	public function get($key);
	/**
	 * 写入数据|并设置有效日期
	 *
	 * @access public
	 * @param string  $name 缓存变量名
	 * @param mixed   $value 存储数据
	 * @param integer $expire 有效时间（秒）|失效时间|0:则不限制过期时间
	 * @return boolean
	*/
	public function set($key,$value,$expire=0);
	/**
	 * 插入数据|并设置有效日期
	 *
	 * @param string $key
	 * @param string $value
	 * @param number $expire
	 * @throws \Exception
	*/
	public function setex($key,$value,$expire=0);
	/**
	 * 删除数据
	 *
	 * @param string $key
	 */
	public function delete($key);
	/**
	 * 清空数据
	*/
	public function clear();
	/**
	 * 关闭链接
	 *
	 * @return null
	 */
	public function close();
}
?>
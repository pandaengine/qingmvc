<?php
namespace qing\session\handler;
use qing\com\Component;
use qing\cache\CacheX;
/**
 * 缓存会话管理器
 * redis
 * memcache
 * file
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CacheHandler extends Component implements \SessionHandlerInterface{
	/**
	 * 缓存组件
	 * 
	 * @var \qing\cache\Cache
	 */
	protected $cache;
	/**
	 * 缓存连接名称
	 *
	 * @var string
	 */
	public $connName;
	/**
	 * id前缀
	 *
	 * @var number
	 */
	public $prefix='sess_';
	/**
	 * 有效期(秒)
	 * 
	 * @var number
	 */
	public $expire=3600;
	/**
	 * 初始化会话
	 * 
	 * @see SessionHandlerInterface::open()
	 * @param string $session_name 会话名称/PHPSESSID
	 */
	public function open($save_path,$session_name){
		//初始化
		$this->cache=CacheX::conn($this->connName);
		//建议设置值前缀
		$this->cache->prefix=$this->prefix;
		return true;
	}
	/**
	 * 读取会话数据
	 * 
	 * @see SessionHandlerInterface::read()
	 */
	public function read($session_id){
		return $this->cache->get($session_id);
	}
	/**
	 * 写入会话数据
	 * 
	 * @see SessionHandlerInterface::write()
	 */
	public function write($session_id,$session_data){
		return $this->cache->set($session_id,$session_data,$this->expire);
	}
	/**
	 * 关闭会话
	 * 
	 * @see SessionHandlerInterface::close()
	 */
	public function close(){
		$this->cache->close();
		return true;
	}
	/**
	 * 销毁会话
	 * 
	 * @see SessionHandlerInterface::destroy()
	 */
	public function destroy($session_id){
		return $this->cache->delete($session_id);
	}
	/**
	 * 清理过期会话
	 * 
	 * @see SessionHandlerInterface::gc()
	 */
	public function gc($maxlifetime){
		return true;
	}
}
?>
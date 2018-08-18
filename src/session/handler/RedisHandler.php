<?php
namespace qing\session\handler;
/**
 * redis会话管理器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class RedisHandler extends CacheHandler{
	/**
	 * redis缓存连接
	 *
	 * @var string
	 */
	public $connName='sess_redis';
}
?>
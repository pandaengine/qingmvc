<?php
namespace qing\cache;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CacheX{
	/**
	 * @param string $conn
	 * @return \qing\cache\Cache
	 */
	static public function conn($conn=''){
		return com(static::comid($conn));
	}
	/**
	 * @param string $conn
	 * @return string
	 */
	static public function comid($conn=''){
		$conn=='' && $conn=KEY_MAIN;
		return 'cache@'.$conn;
	}
	/**
	 * @param string $conn
	 * @return boolean
	 */
	static public function exists($conn){
		return coms()->exists(static::comid($conn));
	}	
}
?>
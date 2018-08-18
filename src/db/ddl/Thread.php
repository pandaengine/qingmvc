<?php
namespace qing\db\ddl;
/**
 * 数据库连接（用户）、线程(mysql)
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Thread{
	/**
	 * 更多信息
	 * select * from information_schema.`PROCESSLIST`
	 * SHOW FULL PROCESSLIST
	 * 
	 * @return string
	 */
	public static function show(){
		//return 'SHOW FULL PROCESSLIST';
		return 'select * from information_schema.`PROCESSLIST`';
	}
	/**
	 * 杀死连接
	 * 杀死线程
	 * 
	 * @param number $pid
	 * @return string
	 */
	public static function kill($pid){
		return 'KILL '.$pid;
	}
}
?>
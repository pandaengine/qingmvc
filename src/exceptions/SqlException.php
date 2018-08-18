<?php
namespace qing\exceptions;
/**
 * - sql执行错误
 * - 查询或执行错误
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SqlException extends Exception{
	/**
	 * $msg="\nSQL QUERY ERROR !<br/>\n[MSG]{$error}<br/>\n[SQL]{$sql}";
	 * $msg="\nSQL EXECUTE ERROR !<br/>\n[MSG]{$error}<br/>\n[SQL]{$sql}";
	 * 
	 * @param string  $sql      sql语句
	 * @param string  $error    错误信息
	 * @param string  $message  错误的信息
	 * @param integer $code     错误码
	 */
	public function __construct($sql,$error,$message='',$code=0){
		if($message===''){
			//默认错误
			$message="{$error} SQL：{$sql}";
		}
		
		//始终记录日志|?:运行环境记录日志
// 		logger()->error($message);
		
		parent::__construct($message,$code);
	}
}
?>
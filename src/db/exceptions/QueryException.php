<?php
namespace qing\db\exceptions;
use qing\exceptions\Exception;
/**
 * - sql执行错误
 * - 查询或执行错误
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class QueryException extends Exception{
	/**
	 * @var string
	 */
	public $title='SQL执行错误 : ';
	/**
	 * @param string  $error	错误信息
	 * @param string  $sql      sql语句
	 */
	public function __construct($error,$sql=''){
		if($sql){
			$error="{$error} SQL: {$sql}";
		}
		parent::__construct($error);
	}
}
?>
<?php
namespace qing\db;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface SqlBuilderInterface{
	const TABLE		= 'TABLE';
	const WHERE 	= 'WHERE';
	const WHERE_CONN= 'WHERE_CONN';
	const FIELDS    = 'FIELDS';
	const ORDERBY   = 'ORDERBY';
	const LIMIT     = 'LIMIT';
	const SET		= 'SET';
	const GROUPBY	= 'GROUPBY';
	const HAVING	= 'HAVING';
	//
	const KEYS      = 'KEYS';
	const VALUES 	= 'VALUES';
	const UPDATES 	= 'UPDATES';
	const COUNT		= 'COUNT';
	//
	const SELECT    = 'SELECT';
	const INSERT    = 'INSERT';
	const INSERTS   = 'INSERTS';
	const REPLACE   = 'REPLACE';
	const REPLACES  = 'REPLACES';
	const UPDATE 	= 'UPDATE';
	const INSERT_UPDATE = 'INSERT_UPDATE';
	const DELETE	= 'DELETE';
	//
	const A_N_D		= 'AND';
	const O_R		= 'OR';
	//LOCK
	const LOCK		= 'LOCK';
	const FOR_UPDATE= 'FOR UPDATE';
	const LOCK_SHARE= 'LOCK IN SHARE MODE';
	/**
	 * 构建sql语句
	 *
	 * @param string $action SQL操作|select|delete
	 * @param array $parts
	 * @return string|mixed
	 */
	public function buildSql($action,array $parts);
}
?>
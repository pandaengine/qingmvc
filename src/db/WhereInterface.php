<?php
namespace qing\db;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface WhereInterface{
	const A_N_D		= 'and';
	const O_R		= 'or';
	const BETWEEN 	= 'between';
	const I_N 		= 'in';
	/**
	 * 分组标识
	 *
	 * @var string
	 */
	const GROUP_LEFT = '(';
	/**
	 * 分组标识
	 *
	 * @var string
	 */
	const GROUP_RIGHT = ')';
	/**
	 * 一个条件语句
	 *
	 * @var string
	 */
	const GROUP_SQL = 'sql';
	/**
	 * 取得条件
	 *
	 * @param boolean $bindOn
	 * @return string
	 */
	public function getWhere($bindOn=true);
	/**
	 * 获取预处理占位符参数
	 *
	 * @return array
	 */
	public function getBindings();
}
?>
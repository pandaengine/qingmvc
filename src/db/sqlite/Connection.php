<?php
namespace qing\db\sqlite;
use qing\filesystem\MK;
/**
 * PDO驱动/预处理写法/提高性能
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Connection extends \qing\db\pdo\Connection{
	/**
	 * 创建数据库连接
	 *
	 * @return string
	 */
	protected function getDns(){
		$host  =$this->host;
		$dbname=$this->name;
		$dbfile=$host.DS.$dbname;
		if(!is_dir(dirname($dbfile))){
			MK::dir(dirname($dbfile));
		}
		$dsn='sqlite:'.$dbfile;
		return $dsn;
	}
}
?>
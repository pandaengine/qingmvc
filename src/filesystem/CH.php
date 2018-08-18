<?php
namespace qing\filesystem;
/**
 * 

chgrp — 改变文件所属的组
chmod — 改变文件模式
chown — 改变文件的所有者

 * 
 * @name CH change
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CH{
	/**
	 * chgrp — 改变文件所属的组
	 * 
	 * @param string $filename
	 * @param string $group
	 * @return boolean
	 */
	public static function grp($filename,$group){
		return chgrp($filename,$group);
	}
	/**
	 * @param string $filename
	 * @param string $mode
	 * @return boolean
	 */
	public static function mod($filename,$mode){
		return chmod($filename,$mode);
	}
	/**
	 *
	 * @param string $filename
	 * @param string $user
	 * @return boolean
	 */
	public static function own($filename,$user){
		return chown($filename,$user);
	}
}
?>
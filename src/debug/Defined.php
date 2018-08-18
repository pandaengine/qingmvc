<?php 
namespace qing\debug;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Defined{
	/**
	 * 已经定义的常量|用户自定义的常量
	 */
	public static function constants_user(){
		return get_defined_constants(true)['user'];
	}
}
?>
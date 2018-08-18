<?php
namespace qing\facades;
/**
 * 注意：
 * - 只需要tip需要继承BaseModel，用于提示
 * - 生产，不需要
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Model extends FacadeSgt{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return '\qing\db\Model';
	}
}
?>
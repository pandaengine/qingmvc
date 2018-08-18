<?php
namespace main\coms;
use qing\com\ComCreator;
/**
 * 组件创建类
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Demo01Creator extends ComCreator{
	/**
	 * @see \qing\com\ComCreator::create()
	 */
	public function create(){
		$com=new Demo01();
		$com->name='Demo01Creator';
		return $com;
	}
}
?>
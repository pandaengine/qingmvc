<?php 
namespace qing\com;
use qing\com\Component;
/**
 * 组件案例
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Demo01 extends Component{
	/**
	 * public属性可直接配置
	 * 
	 * @var string
	 */
	public $name;
	/**
	 * protected属性，需要通过public的set方法配置
	 * 
	 * @var string
	 */
	protected $nickname;
	/**
	 * @see \qing\com\ComponentInterface::initComponent()
	 */
	public function initComponent(){
		//创建组件会执行一次该函数
		//用于初始化组件
	}
	/**
	 * @param string $nickname
	 */
	public function setNickname($nickname){
		
	}
}	
?>
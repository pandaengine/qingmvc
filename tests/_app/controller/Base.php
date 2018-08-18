<?php
namespace main\controller;
/**
 * 控制器基类
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingcms.com
 */
class Base extends \qing\controller\Controller{
	/**
	 * 用户信息，未实现
	 * 
	 * @var number
	 */
	protected $uid=0;
	/**
	 * @return boolean
	 */
	protected function beforeAction(){
		$this->uid=0;
		return true;
	}
	/**
	 * @param string $title
	 * @return boolean
	 */
	protected function setTitle($title){
		$GLOBALS['title']=$title;
	}
	/**
	 */
	public function common(){
		dump(__METHOD__);
	}
}
?>
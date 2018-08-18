<?php
namespace main\controller;
//
class AAA{
	public function __construct(){
		dump(__METHOD__);
	}
}
class BB{
	public function __construct($a){
		dump(__METHOD__);
		dump(get_defined_vars());
	}
}
class BBB extends BB{
	public function __construct(){
		//parent::__construct('aaa');
		//dump(__METHOD__);
		//exit();
	}
}
/**
 * @diClass
 * @author xiaowang <736523132@qq.com>
 * @copyright 2013 qingmvc http://qingcms.com
 */
class Cat extends Base{
	/**
	 * @di
	 * @var \main\model\Cat
	 */
	public $mCat;
	/**
	 * @di
	 * @var \main\model\Note
	 */
	public $mNote;
	/**
	 *
	 */
	public function setCCC(AAA $a,BBB $b){
// 		dump(__METHOD__);
// 		dump(get_defined_vars());
	}
	/**
	 * 
	 */
	public function __construct(AAA $a,BBB $b){
// 		dump(__METHOD__);
// 		dump(get_defined_vars());
	}
	/**
	 * 默认操作首页
	 */
	public function index(){
	}
}
?>
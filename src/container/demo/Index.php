<?php
namespace main\controller;
use qing\facades\Container;
use qing\container\DIContainer;
// use main\libs\DataUtil;
// use qing\mv\MV;
/**
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright 2013 qingmvc http://qingcms.com
 */
class Index extends Base{
	/**
	 * 默认操作首页
	 */
	public function index(){
		//dump(__METHOD__);
// 		dump(\MV::error());
// 		exit();

		/**/
		//$container=Container::getInstance();
		$container=new DIContainer();
		$container->set('\main\models\Sites','\main\models\Sites');
		$container->set('\main\controller\Cat',['class'=>'\main\controller\Cat','mCat'=>'\main\models\Sites','CCC'=>'::di']);
		$container->set('main\controller\AAA','main\controller\AAA');
		$container->set('main\controller\BBB','main\controller\BBB');
		
		dump($container->get('\main\controller\Cat'));
		exit();
		
		return $this->render('');
		//return MV::error('haha',[MV::autojump=>false,MV::redirect=>'baidu.com']);
	}
}
?>
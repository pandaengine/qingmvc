<?php
namespace qing\views;
use qing\view\ViewInterface;
use qing\mv\ModelAndView;
/**
 * smarty视图
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SmartyView implements ViewInterface{
	/**
	 * @see \qing\view\ViewInterface::render()
	 */
	public function render(ModelAndView $mv){
		/* @var $com \qing\views\Smarty */
		$com   =com('smarty');
		$smarty=$com->getSmarty();
		$smarty->assign($mv->vars);
		return $smarty->fetch($mv->viewName);
	}
}
?>
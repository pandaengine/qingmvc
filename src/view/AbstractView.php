<?php
namespace qing\view;
use qing\mv\ModelAndView;
/**
 * 抽象视图
 * 
 * @deprecated
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
abstract class AbstractView implements ViewInterface{
	/**
	 * @see \qing\view\ViewInterface::render()
	 */
	abstract public function render(ModelAndView $mv);
}
?>
<?php
namespace qing\view;
use qing\mv\ModelAndView;
use qing\exceptions\NotmatchClassException;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class V{
	/**
	 * 渲染视图
	 *
	 * - 不支持响应
	 * - 也不支持视图返回响应，视图中要处理响应需要直接发送
	 *
	 * @param \qing\mvc\ModelAndView $mv
	 * @return \qing\http\Response 返回响应对象|或响应字符内容
	 */
	public static function render(ModelAndView $mv){
		//#取得视图组件
		if($mv->render){
			//#指定渲染器组件
			$view=com($mv->render);
		}else{
			//#默认视图组件
			$view=com('view');
		}
		if(!$view instanceof ViewInterface){
			throw new NotmatchClassException(get_class($view),ViewInterface::class);
		}
		//#返回视图内容|返回响应|转向视图?
		return $view->render($mv);
	}
}
?>
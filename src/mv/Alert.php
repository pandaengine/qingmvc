<?php
namespace qing\mv;
/**
 * 系统默认消息处理器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Alert extends Message{
	/**
	 * 默认消息提示
	 *
	 * @param array $params
	 * @return string
	 */
	public static function show(array $params){
		/**
		 * #用户可以自定义，
		 * 但注意：
		 * - 框架的扩展函数加载后，初始化主模块才导入common/function，
		 * - 如果要先于该函数定义，需要手动载入common/myfunction
		 */
		if(function_exists('\alert')){
			//自定义的alert
			return \alert($params);
		}
		//---
		if(!isset($params['autojump'])){
			if($params['success']){
				//#success
				$params['autojump']=true;
			}else{
				//#error
				$params['autojump']=false;
			}
		}
		//#
		$tpl=__DIR__."/views/message.html";
		//模板阵列变量分解成为独立变量
		extract($params,EXTR_OVERWRITE);
		include $tpl;
		return MV_NULL;
	}
}
?>
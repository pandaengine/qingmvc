<?php
namespace qing\mv;
/**
 * 消息包|错误或成功消息包
 * 
 * @name MSG
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Bag{
	/**
	 * 创建一个消息包
	 *
	 * @param number $succ 成功或失败
	 * @param string $msg  消息
	 * @param array $params 附加数据
	 * @return \qing\mv\MessageBag
	 */
	static public function message($succ,$msg='',array $params=[]){
		if(!$msg){
			$msg=$succ?L()->msg_success:L()->msg_error;
		}
		return new MessageBag($succ,$msg,$params);
	}
	/**
	 * 返回成功消息包
	 *
	 * @param string $message
	 * @param array  $params
	 * @return \qing\mv\MessageBag
	 */
	static public function success($message='',array $params=[]){
		return static::message(true,$message,$params);
	}
	/**
	 * 返回操作失败消息包
	 *
	 * @param string $message
	 * @param array  $params
	 * @return \qing\mv\MessageBag
	 */
	static public function error($message='',array $params=[]){
		return static::message(false,$message,$params);
	}
}
?>
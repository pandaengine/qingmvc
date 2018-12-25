<?php
namespace qing\mv;
/**
 * 消息提示
 * - ajax: json/jsonp/xml
 * - 视图消息
 * 
 * @name message.ajax Ajax
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Message{
	/**
	 * @var string
	 */
	const success='success';
	/**
	 * @var bool
	 */
	const message='message';
	/**
	 * 跳转到
	 *
	 * @var string
	 */
	const redirect='redirect';
	/**
	 * 自动跳转
	 *
	 * @var bool
	 */
	const autojump='autojump';
	/**
	 * 刷新
	 *
	 * @var string
	 */
	const reload='reload';
	/**
	 * 操作成功消息
	 *
	 * @param string $message
	 * @param array $params
	 * @return \qing\response\Json
	 */
	public static function success($message='',array $params=[]){
		return static::message(1, $message, $params);
	}
	/**
	 * 操作失败消息
	 *
	 * @param string $message
	 * @param array $params
	 * @return \qing\response\Json
	 */
	public static function error($message='',array $params=[]){
		return static::message(0, $message, $params);
	}
	/**
	 * @param string $success 0/1
	 * @param string $message 消息
	 * @param string $params  附件参数
	 * @return
	 */
	public static function message($success,$message='',array $params=[]){
		if(!$message){
			$message=$success?L()->msg_success:L()->msg_error;
		}
		if($success){
			$success=1;
		}else{
			$success=0;
		}
		$datas=[];
		$datas[self::success]=$success;
		$datas[self::message]=$message;
		if($params){
			$datas=array_merge($datas,$params);
		}
		return static::show($datas);
	}
	/**
	 * @param array $datas
	 */
	public static function show(array $datas){
		dump(__METHOD__);
		dump($datas);
	}
	/**
	 * @param array $datas
	 */
	public static function fromBag(MessageBag $bag){
		return self::message($bag->success,$bag->message,$bag->params);
	}
}
?>
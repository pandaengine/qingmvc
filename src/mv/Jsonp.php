<?php
namespace qing\mv;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Jsonp extends Message{
	/**
	 * jsonp回调函数
	 * ?callback=json1
	 * 
	 * @var string
	 */
	static public $callbackField='callback';
	/**
	 * - 回调函数的规则
	 * - 必须验证，否则有脚本安全
	 * - 如果随便指定函数都返回执行的话，有脚本安全
	 * - alert()
	 * - json1/json2/callback1/callback2
	 * 
	 * @var string
	 */
	static public $callbackRule='/^json\d+$/i';
	static public $callback;
	/**
	 * 注意：回调函数的安全性必须验证
	 * 
	 * @return string
	 */
	static protected function getCallback(){
		if(static::$callback){
			return static::$callback;
		}
		//$_GET[static::$callbackField]='alert(123);json222';
		if(isset($_GET[static::$callbackField])){
			$callback=(string)$_GET[static::$callbackField];
			if(!static::$callbackRule){
				return $callback;
			}else if(preg_match(static::$callbackRule,$callback)){
				//验证回调函数规则，避免xss.js
				return $callback;
			}
		}
		throw new \Exception('jsonp callback not exist');
	}
	/**
	 * @param array $datas
	 * @return \qing\response\JsonResponse
	 */
	static public function show(array $datas){
		//\qing\response\Json包含callback会转换为jsonp
		return new \qing\response\Json($datas,static::getCallback());
	}
}
?>
<?php
namespace qing\exceptions\http;
/**
 * 500=>'Internal Server Error',
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ServerErrorHttpException extends HttpException{
	/**
	 * @param string $message  错误的信息
	 * @param integer $code    错误码
	 */
	public function __construct($message=null,$code=0){
		parent::__construct(500,$message,$code);
	}
}
?>
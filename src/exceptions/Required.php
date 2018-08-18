<?php
namespace qing\exceptions;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Required extends Exception{
	/**
	 * @param string  $item
	 * @param string  $message  错误的信息
	 * @param integer $code     错误码
	 */
	public function __construct($item,$message='',$code=0){
		if($message===''){
			$message='不能为空 : '.$item;
		}else{
			$message=$message.' : '.$item;
		}
		parent::__construct($message,$code);
	}
}
?>
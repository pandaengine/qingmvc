<?php
namespace qing\exceptions\http;
/**
 * 找不到模块
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class NotFoundModuleException extends NotFoundHttpException{
	/**
	 * 模块未初始化，无法使用模块getMessage
	 * 
	 * @var string
	 */
	public $handler='alert';
	/**
	 * 模块名称
	 * 
	 * @var string
	 */
	public $module='';
	/**
	 * @param string  $module   模块名称
	 * @param string  $message  错误的信息
	 * @param integer $code     错误码
	 */
	public function __construct($module,$message='',$code=0){
		$this->module=$module;
		if($message===''){
			$message='找不到模块:'.$module;
		}
		parent::__construct($message,$code);
	}
}
?>
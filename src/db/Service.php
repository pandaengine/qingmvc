<?php
namespace qing\db;
use qing\com\Component;
/**
 * 服务|复杂的业务逻辑
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Service extends Component{
	/**
	 * 错误信息
	 *
	 * @var string
	 */
	protected $error='';
	/**
	 * 获取模型内部错误信息
	 *
	 * @return string
	 */
	public function getError(){
		return $this->error;
	}
	/**
	 * 设置错误信息
	 *
	 * @return string
	 */
	public function setError($error){
		$this->error=$error;
	}
}
?>
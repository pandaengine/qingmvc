<?php
namespace qing\mv;
/**
 * 消息包|错误或成功消息包
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class MessageBag{
	/**
	 * 成功消息还是错误消息
	 *
	 * @var boolean
	 */
	public $success=true;
	/**
	 * 提示消息
	 *
	 * @var string
	*/
	public $message='操作成功';
	/**
	 * 附加参数
	 *
	 * @var array
	 */
	public $params=[];
	/**
	 * 构造函数
	 * 
	 * @param string $success
	 * @param string $message
	 * @param array  $params
	 */
	public function __construct($success=true,$message='',array $params=[]){
		$this->success($success);
		$this->message($message);
		$this->params($params);
	}
	/**
	 * @param boolean $value
	 * @return $this
	 */
	public function success($value){
		$this->success=(bool)$value;
		return $this;
	}
	/**
	 * @param string $value
	 * @return $this
	 */
	public function message($value){
		$this->message=(string)$value;
		return $this;
	}
	/**
	 * @param array $values
	 * @return $this
	 */
	public function params(array $values){
		$this->params=$values;
		return $this;
	}
	/**
	 * 成功或失败
	 * 
	 * @return boolean
	 */
	public function isSuccess(){
		return (bool)$this->success;
	}
	/**
	 * 获取参数
	 *
	 * @param string $key
	 * @return string
	 */
	public function get($key){
		return isset($this->params[$key])?$this->params[$key]:null;
	}
	/**
	 * 
	 * @param string $key
	 * @param string $value
	 * @return string
	 */
	public function set($key,$value){
		$this->params[$key]=$value;
	}
	/**
	 * 取得属性
	 * ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED
	 *
	 * @param number $propFilter
	 * @return array
	 */
	public function getProps($propFilter=\ReflectionProperty::IS_PUBLIC){
		$rows	 =array();
		$refClass=new \ReflectionClass($this);
		$props   =$refClass->getProperties($propFilter);
		foreach($props as $prop){
			/*@var $prop \ReflectionProperty */
			$propName =$prop->getName();
			$propValue=$prop->getValue($this);
			$rows[$propName]=$propValue;
		}
		return $rows;
	}
	/**
	 * 返回字符串格式,echo/print会触发该方法
	 * 
	 * @return array
	 */
	public function __toString(){
		return json_encode($this->getProps(),JSON_UNESCAPED_UNICODE);
	}
}
?>
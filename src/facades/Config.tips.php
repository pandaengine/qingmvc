<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @see qing\base\Configs
 */
class Config extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return 'configs';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\config\Config
	 */
	static protected function getInstance(){
		
	}
	/**
	 * 
	 */
	static public function setConfigs($values){
		static::getInstance()->setConfigs($values);
	}
	/**
	 * 
	 */
	static public function getConfigs(){
		static::getInstance()->getConfigs();
	}
	/**
	 * 
	 */
	static public function sets($values){
		static::getInstance()->sets($values);
	}
	/**
	 * 
	 */
	static public function set($key,$value){
		static::getInstance()->set($key,$value);
	}
	/**
	 * 
	 */
	static public function get($key,$sub=''){
		static::getInstance()->get($key,$sub);
	}
	/**
	 * 
	 */
	static public function getClosure($key){
		static::getInstance()->getClosure($key);
	}
}
?>
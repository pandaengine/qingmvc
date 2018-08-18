<?php
namespace qing\app\traits;
use qing\facades\Coms;
use qing\app\Module;
use qing\Qing;
use qing\exceptions\NotmatchClassException;
/**
 * 应用主线之模块支持
 * 应用模块支持,默认为main模块,用于处理当前模块的信息
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
trait ModuleTrait{
	/**
	 * @var array
	 */
	public $moduleNames=[];
	/**
	 * @var array
	 */
	protected $_modules=[];
	/**
	 * @param string $module
	 * @return string
	 */
	public static function modComName($module){
		return 'module@'.$module;
	}
	/**
	 * 初始化主模块
	 *
	 * @return MainModule
	 */
	protected function initMainModule(){
		$modName=self::modComName(MAIN_MODULE);
		if(!Coms::has($modName)){
			Coms::set($modName,['class'=>'\qing\app\MainModule']);
		}
	}
	/**
	 * @return array
	 */
	public function getModules(){
		return $this->moduleNames;
	}
	/**
	 * 判断是否有某个模块
	 *
	 * @see module_exists
	 * @param string $modName
	 * @return boolean
	 */
	public function hasModule($modName){
		return Coms::has(self::modComName($modName));
	}
	/**
	 * 设置模块
	 * 
	 * @param array $modules
	 */
	public function setModules(array $modules){
		foreach($modules as $name=>$module){
			$this->setModule($name,$module);
		}
	}
	/**
	 * 模块当组件处理
	 *
	 * @param string $name
	 * @param string $module
	 */
	public function setModule($name,$module){
		$this->moduleNames[$name]=$name;
		Coms::set(self::modComName($name),$module);
	}
	/**
	 * 主要模块
	 * 一直存在
	 *
	 * @return \qing\app\MainModule
	 */
	public function getMainModule(){
		return $this->getModule(MAIN_MODULE);
	}
	/**
	 * 获取模块
	 *
	 * @param string $name
	 * @return \qing\app\MainModule|\qing\app\Module
	 */
	public function getModule($modName){
		/*@var $coms 	\qing\com\Coms */
		/*@var $module 	\qing\app\Module */
		$comName=self::modComName($modName);
		$coms=Qing::$coms;
		if($coms->hasInstance($comName)){
			//#服务已加载
			return $coms->get($comName);
		}
		//#第一次创建组件
		$module=$coms->get($comName);
		if(!$module instanceof Module){
			throw new  NotmatchClassException(get_class($module),Module::class);
		}
		$module->modName=$modName;
		$module->initModule();
		return $module;
	}
}
?>
<?php
/**
 * 公共函数库
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
use qing\facades\Coms;
use qing\facades\Config;
use qing\facades\Request;
use qing\facades\UrlManager;
use qing\Qing;
use qing\config\Option;
/**
 * 核心函数库，框架运行必备函数
 * 命名：下划线法|不使用驼峰法
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
if(!function_exists('dump')){
	/**
	 * 打印变量
	 * php7 
	 * 
	 * //# 定义
	 * function dump(...$vars){}
	 * //# 调用
	 * dump(...[1,2,3]);
	 * 
	 * @param string $var
	 * @param boolean $pre
	 */
	function dump($var=''){
		$args=func_get_args();
		if(!APP_CLI) echo "<pre>";
		echo "\n";
		if(count($args)==1){
			//一个参数
			var_dump($args[0]);
		}else{
			//多个参数
			var_dump($args);
		}
		echo "\n";
		if(!APP_CLI) echo "</pre>";
	}
}
/**
 * 行内打印
 * 
 * @name dump inline/ln
 * @param string $var
 * @param string $br
 */
function dump_ln($var,$br=false){
	var_dump($var);echo "\n";if($br && PHP_SAPI!='cli'){ echo "<br/>"; }
}
//组件
/**
 * 返回应用实例
 *
 * @return \qing\app\WebApp
 */
function app(){
	return Qing::$app;
}
/**
 * 主模块
 *
 * @name base
 * @return \qing\app\MainModule
 */
function main(){
	return Qing::$app->getMainModule();
}
/**
 * 当前模块/自定义模块/主模块
 *
 * @name module
 * @param string $modName 默认为当前所在模块/非主模块
 * @return \qing\app\Module|\qing\app\MainModule
 */
function mod($modName=''){
	if(!$modName){
		//#默认为当前模块|包括转发后的模块
		if(!defined('MODULE_NAME')){
			throw new \Exception('路由未初始化，找不到模块');
		}
		$modName=MODULE_NAME;
	}
	return Qing::$app->getModule($modName);
}
/**
 * - 组件加载器别名
 * - 组件管理器
 * - 组件模块
 *
 * @return \qing\com\Coms
 */
function coms(){
	return Qing::$coms;
}
/**
 *
 * @return \qing\com\Coms
 */
function com($id=''){
	if($id>''){
		return Qing::$coms->get($id);
	}else{
		return Qing::$coms;
	}
}
/**
 * 应用内语言翻译
 *
 * @see \qing\lang\Lang
 * @param string $key
 * @param array $params
 * @return \main\lang\zh_cn|\L|\qing\lang\L
 */
function L($key='',array $params=[]){
	if($key){
		//函数式调用/L('lang01',['abc',123]);
		return Coms::lang()->get($key,$params);
	}else{
		//返回对象实例
		static $_lang=null;
		if($_lang){ return $_lang; }
		return $_lang=new \qing\lang\L();
	}
}
/**
 * 取得配置信息
 *
 * @param string $key
 */
function config($key){
	return Config::get($key);
}
/**
 *
 * @param string $key
 * @param string $value
 */
function set_config($key,$value){
	return Config::set($key,$value);
}
/**
 * 碎片化的配置文件信息
 *
 * @param string $opt
 * @param string $key
 */
function option($opt,$key=''){
	return Option::get($opt,$key);	
}
/**
 * 生成url
 * __M__ __C__ __A__
 *
 * @see \qing\url\U
 * @param string $ctrl
 * @param string $action
 * @param array $params
 * @return string
 */
function U($ctrl,$action='',array $params=[]){
	//自动使用当前模块
	if(MODULE_NAME==MAIN_MODULE){
		//主模块
		$module='';
	}else{
		$module=MODULE_NAME;
	}
	if(!$ctrl){
		//#空则自动获取
		$ctrl=CTRL_NAME;
	}
	return UrlManager::create($module,$ctrl,$action,$params);
}
/**
 * url创建器
 *
 * @see \qing\url\U
 * @param string $module
 * @param string $ctrl
 * @param string $action
 * @param array  $params
 * @return string
 */
function url($module,$ctrl='',$action='',array $params=[]){
	return UrlManager::create($module,$ctrl,$action,$params);
}
/**
 *
 * @return boolean
 */
function onlyGet(){
	Request::onlyGet();
}
/**
 *
 * @return boolean
 */
function onlyPost(){
	Request::onlyPost();
}
/**
 * 小部件
 *
 * @param string $name
 * @param mixed $data
 * @param string $module
 */
function widget($name,$data=null,$module=null){
	return com('widget')->run($name,$data,$module);
}
?>
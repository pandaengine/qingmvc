<?php
namespace qing\config;
use qing\interceptor\Interceptor;
use qing\exceptions\NotfoundFileException;
/**
 * 配置缓存拦截器
 * 
 * - 数组数据 
 * - 无法获取的define常量
 * 
 * 无法监测：
 * - 对象属性的修改
 * - 闭包函数代码
 * 
 * # 直接解释include等包含
 * 
 * # 常见错误
 * - 常量重复定义：notice: Constant ZONE_NUMS already defined 
 * 	 解决办法：defined('') or define('','');
 * - 
 * 
 * # 缓存
 * - 缓存，配置文件中有闭包函数等无法序列化的不能缓存
 * - 闭包函数等无法序列化的数据保存到include文件
 * - define等信息无法缓存
 * - scripts:使用脚本加载动态配置 
 * - \/\* include ''; \*\/
 * 
 * @name acc
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class AppConfigCacheInterceptor extends Interceptor{
	/**
	 *
	 * @var array
	 */
	public $configPath='';
	/**
	 *
	 * @var array
	 */
	public $envs=[];
	/**
	 *
	 * @var boolean
	 */
	public $debug=true;
	/**
	 *
	 * @var array
	 */
	protected $_configFile;
	/**
	 *
	 * @var array
	 */
	protected $_consts=[];
	/**
	 * @see \qing\interceptor\Interceptor::preHandle()
	 */
	public function preHandle(){
		if(!$this->envs){ return true; }
		//
		$this->_consts=get_defined_constants(true)['user'];
		$this->configPath=APP_CONFIG;
		//		
		foreach($this->envs as $env){
			$configFile=$this->configPath.DS.$env.PHP_EXT;
			$cacheFile =$this->configPath.DS.'_'.$env.PHP_EXT;
			//
			$content=$this->buildContent($configFile);
			//
			file_put_contents($cacheFile,$content);
		}
		return true;
	}
	/**
	 * - 不缓存 include_once,require_once：一般用于定义常量define
	 * - 只缓存 include require
	 * 
	 * /s 点号包括换行.*
	 * 
	 * @param string $env
	 */
	protected function buildContent($configFile){
		$content=file_get_contents($configFile);
		//遇到,)];结束
		//数组结尾: ,)] 需要恢复
		//行结尾 : ; 不需要恢复
		$pattern='/(include|require|include_once|require_once)\s+(.+?)([,\)\];])/is';
		$content=preg_replace_callback($pattern,function($matches)use($configFile){
			$filename=$matches[2];
			$filename=$this->parseFileName($filename,$configFile);
			//
			$content=$this->includeContent($filename);
			$suffix=$matches[3];
			if($suffix!=';'){
				$content.=$suffix;
			}
			if($this->debug){
				$content="\n//[ include {$filename} ]\n".$content;
			}
			return $content;
		},$content);
		//
		return $content;
	}
	/**
	 * @param string $file
	 */
	protected function includeContent($file){
		$content=file_get_contents($file);
		$content=preg_replace('/(^\<\?php\s*|\s*\?\>$|\s*$)/i','',$content);
		
		//如果是返回配置，也可以不是，比如define或者只是定义变量$db再使用
		if(preg_match('/^\s*return\s+/i',$content)){
			$content=preg_replace('/(^\s*return\s+|;\s*$)/i','',$content);
		}
		
		return $content;
	}
	/**
	 * 只支持解析常量
	 * 
	 * @param string $filename
	 * @param string $configFile
	 */
	protected function parseFileName($filename,$configFile){
		$_filename=$filename;
		//
		//匹配常量/^CCC.'/'.CCC.'/'.CCC$
		$filename=preg_replace_callback('/(^(.+?)\.[\'\"]|[\'\"]\.(.+?)\.[\'\"]|[\'\"]\.(.+?)$)/',function($matches)use($configFile){
			$const=$matches[2];
			//解析常量
			if($const=='__DIR__'){
				return dirname($configFile);
			}else if($const=='__FILE__'){
				return $configFile;
			}else if(isset($this->_consts[$const])){
				return $this->_consts[$const];
			}else{
				throw new \Exception(__METHOD__.' const not found: '.$const);
			}
			
		},$filename);
		//
		$filename=trim($filename);
		$filename=trim($filename,'\"\'');
		if(!is_file($filename)){
			throw new NotfoundFileException($_filename.' / '.$filename);
		}
		return $filename;
	}
}
?>
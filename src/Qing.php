<?php
namespace qing;
use qing\app\WebApp;
use qing\app\ServerApp;
/**
 * 框架核心管理类|使用类启动可以配置加载器启动不需要包括文件
 * 
 * @link QingMVC [ QING IS NOT SIMPLE ]
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Qing{
	/**
	 * 应用实例
	 * 
	 * @var \qing\app\WebApp
	 */
	public static $app;
	/**
	 * 组件管理器
	 *
	 * @var \qing\com\Coms
	 */
	public static $coms;
	/**
	 * 存储应用上下文实例
	 * 返回应用单例，如果单例不存在则返回null
	 *
	 * @return \qing\app\WebApp
	 */
	public static function app(){
		return self::$app;
	}
	/**
	 * 设置主应用实例
	 * 
	 * @param object $app
	 */
	public static function setApp($app){
		self::$app=$app;
	}
	/**
	 * 创建App
	 *
	 * @param string $configFile 应用配置目录
	 * @return \qing\app\WebApp
	 */
	public static function createServerApp($configFile){
		return new ServerApp($configFile);
	}
	/**
	 * 启动服务器应用
	 * - 依赖于web应用
	 * - 不需要initRuntime
	 *
	 * @param string $configFile
	 */
	public static function runServerApp($configFile){
		// 初始化应用环境
		$app=self::createServerApp($configFile);
		// 执行应用
		$app->run();
		return $app;
	}
	/**
	 * 创建WebApp
	 *
	 * @param string $configFile 应用配置目录
	 * @return \qing\app\WebApp
	 */
	public static function createWebApp($configFile){
		return new WebApp($configFile);
	}
	/**
	 * 启动应用
	 */
	public static function runWebApp($configFile){
		// 初始化应用环境
		$app=new WebApp($configFile);
		// 执行应用
		$app->run();
		return $app;
	}
	/**
	 * 各种类静态属性
	 * 各种全局变量
	 * 和unset类似，变量引用计数为0时被释放
	 */
	public static function destroyApp(){
		self::$app=null;
		self::$coms=null;
	}
}
?>
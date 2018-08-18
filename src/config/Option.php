<?php
namespace qing\config;
use qing\exceptions\NotfoundFileException;
/**
 * 碎片化的配置文件信息
 * 懒加载，使用才获取包含
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Option{
	/**
	 * static $options=[];
	 * $GLOBALS['options']=[];
	 * 
	 * @var array
	 */
	public static $options=[];
	/**
	 *
	 * @param string $opt 碎片配置文件名
	 * @param string $key
	 */
	public static function get($opt,$key=''){
		if(!isset(self::$options[$opt])){
			//#配置文件未加载，只加载一次
			$path=APP_CONFIG;
			$file=$path."/{$opt}.php";
			if(!is_file($file)){
				throw new NotfoundFileException("option({$opt}) {$file} ");
			}
			$option=include $file;
			if(defined('APP_ENV') && APP_ENV>''){
				//#合并环境配置
				$env=APP_ENV;
				$file_env=$path."/{$opt}.{$env}.php";
				if(is_file($file_env)){
					$option_env=(array)include $file_env;
					$option=array_replace_recursive($option,$option_env);
				}
			}
			self::$options[$opt]=$option;
		}else{
			//#配置文件已加载
			$option=self::$options[$opt];
		}
		if(!$key){
			return $option;
		}else{
			return isset($option[$key])?$option[$key]:null;
		}
	}
	/**
	 * 压入多余配置
	 * 
	 * @param string $opt
	 * @param array $options
	 */
	public static function set($opt,array $options){
		if(!isset(self::$options[$opt])){
			//初始化数据
			self::get($opt);
		}
		self::$options[$opt]=array_merge(self::$options[$opt],$options);
	}
	/**
	 * 移除配置
	 *
	 * @param string $opt 碎片配置文件名
	 */
	public static function un($opt){
		if(isset(self::$options[$opt])) unset(self::$options[$opt]);
	}
}
?>
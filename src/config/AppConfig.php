<?php
namespace qing\config;
use qing\Qing;
use qing\exceptions\NotfoundFileException;
use qing\exceptions\NotSupportException;
/**
 * App环境配置
 * ---
 * 如果您想要更灵活的环境侦测方式，可以传递一个 闭包（Closure） 给 detectEnvironment 函数
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class AppConfig{
	/**
	 * 初始化配置
	 * 指定环境APP_ENV
	 * 
	 * @param string $configFile
	 */
	static public function get($configFile){
		$configs=(array)require $configFile;
		//
		if(defined('APP_ENV') && APP_ENV){
			//#指定环境
			$env=APP_ENV;
		}else{
			//#侦测环境
			//environments:环境列表
			if(isset($configs['environments'])){
				$env=static::detectEnv((array)$configs['environments']);
				unset($configs['environments']);
			}else{
				$env='';
			}
			define('APP_ENV',$env);
		}
		Qing::$app->environment=$env;
		//合并环境设置
		if($env){
			//#环境配置文件
			$envFile=Qing::$app->configPath.DS.$env.'.php';
			if(!is_file($envFile)){
				throw new NotfoundFileException('环境配置文件,'.$envFile);
			}
			$envConfig=(array)require $envFile;
			if($envConfig){
				//合并环境配置到主配置
				//$configs=array_merge_recursive($configs,$envConfig);
				$configs=array_replace_recursive($configs,$envConfig);
			}
		}
		return $configs;
	}
	/**
	 * 探测环境
	 * 如果您想要更灵活的环境侦测方式，可以使用闭包（Closure）
	 *
	 * @param array $envs
	 */
	public static function detectEnv(array $envs){
		$host=self::getHostName();
		//
		foreach($envs as $env=>$hosts){
			if(is_array($hosts)){
				//#数组
				if(in_array($host,$hosts)){
					return $env;
				}
			}elseif(is_string($hosts)){
				//#字符串
				if($host==$hosts){
					return $env;
				}
			}elseif($hosts instanceof \Closure){
				//#闭包函数|返回true则匹配成功
				if(call_user_func($hosts)){
					return $env;
				}
			}else{
				throw new NotSupportException('环境配置不支持');
			}
		}
		return '';
	}
	/**
	* 主机名称检测方法|hostname主机名
	* win	|ipconfig /all 主机名
	* linux|hostname
	*
	* @return string
	*/
	static protected function getHostName(){
		return gethostname();
	}
}
?>
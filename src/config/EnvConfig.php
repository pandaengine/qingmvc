<?php 
namespace qing\config;
/**
 * 应用的配置解析
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class EnvConfig{
	/**
	 * 合并环境设置
	 * 
	 * @param array $mainConfig
	 * @param string $env
	 * @param string $configPath
	 */
	static public function mergeEnvConfig(array &$mainConfig,$env,$configPath){
		//#自定义的环境配置|app/config/__local.php
		$envFile=$configPath.DS.$env.'.php';
		if(!is_file($envFile)){
			throw new \qing\exceptions\NotfoundFileException($envFile);
		}
		$envConfig=(array)require $envFile;
		if($envConfig){
			//使用环境配置替换主配置
			//$mainConfig=array_merge_recursive($mainConfig,$envConfig);
			$mainConfig=array_replace_recursive($mainConfig,$envConfig);
		}
	}
	/**
	 * unset($mainConfig['envs']);
	 * unset($mainConfig['env']);
	 * 
	 * //#指定环境
	 * 'env'=>'',
	 * //设置可侦测环境|只有在主配置有效
	 * 'envs'=>
	 * [
	 * 	 '__local' =>['hostname','tp-xiaowang']
	 * ],
	 * 
	 * @param array $mainConfig
	 * @return string
	 */
	static public function getEnv(array &$mainConfig){
		if(!isset($mainConfig['environments'])){
			//没有设置环境
			return '';
		}
		//#环境列表
		$envs=(array)$mainConfig['environments'];
		unset($mainConfig['environments']);
		if(!$envs){
			return '';
		}
		if(isset($mainConfig['environment'])){
			//#指定环境|为空时，不使用任何环境，使用默认主配置
			$env=(string)$mainConfig['environment'];
			unset($mainConfig['environment']);
			if($env && !isset($envs[$env])){
				throw new \Exception('env not found : '.$env);
			}
		}else{
			//#应用环境侦测
			$env=(string)\qing\config\EnvDetector::getEnv($envs);
		}
		return $env;
	}
}
?>
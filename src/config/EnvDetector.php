<?php
namespace qing\config;
/**
 * 环境探测器
 * ------------
 * 如果您想要更灵活的环境侦测方式，可以传递一个 闭包（Closure） 给 detectEnvironment 函数
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class EnvDetector{
	/**
	 * 探测环境
	 * 如果您想要更灵活的环境侦测方式，可以使用闭包（Closure）
	 *
	 * @param array $envs
	 */
	public static function getEnv(array $envs){
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
				$res=call_user_func($hosts);
				if($res){
					return $env;
				}
			}else{
				throw new \qing\exceptions\NotSupportException('环境配置不支持');
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
	protected static function getHostName(){
		return gethostname();
	}
}
?>
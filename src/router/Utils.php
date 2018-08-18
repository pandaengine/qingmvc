<?php
namespace qing\router;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Utils{
	/**
	 * path路由解析
	 *
	 * #字符串
	 * test/Error/index
	 * test@Error@index
	 *
	 * #数组
	 * [error,index]
	 * [main,error,index]
	 *
	 * @param string $route
	 * @return array 3段或2段
	 */
	static public function byArr(array $route){
		$count=count($route);
		if($count==1){
			$route=[$route[0],DEF_ACTION];
		}
		//追加模块
		//$count==2 && array_unshift($route,MAIN_MODULE);
		return $route;
		 
	}
	/**
	 * .test/Error/index
	 * .test@Error@index
	 *
	 * @param string $route
	 * @param string $delimiter / @
	 */
	static public function byStr($route,$delimiter='/'){
		$route=(string)$route;
		//移除模块标识符
		$route=ltrim($route,R_MODSIGN);
		$route=explode($delimiter,$route);
		return static::byArr($route);
	}
	/**
	 * 格式化路由
	 * 数组或字符串
	 * 
	 * @param string $route
	 */
	static public function format($route){
		if(is_array($route)){
			return self::byArr($route);
		}else{
			return self::byStr((string)$route);
		}
	}
	/**
	 * 数组转为RouteBag
	 * 
	 * @param array $route
	 */
	static public function toBag(array $route){
		if(count($route)==2){
			return new RouteBag(MAIN_MODULE,$route[0],$route[1]);
		}else{
			return new RouteBag($route[0],$route[1],$route[2]);
		}
	}
}
?>
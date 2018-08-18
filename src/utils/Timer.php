<?php
namespace qing\utils;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Timer{
	/**
	 * - 是否过期，每次从缓存文件中获取上一次检测时间进行比较
	 * - 每次都检测，损害较大
	 * 
	 * @param string $id 进程id
	 * @param number $timeout 过期时间/单位:秒
	 * @return string
	 */
	public static function timeout($id,$timeout=60){
		$lasttime =0;
		$nowtime  =time();
		$cacheFile=APP_RUNTIME.DS.$id.'.timeout';
		if(is_file($cacheFile)){
			$lasttime=(int)file_get_contents($cacheFile);
		}
		if($lasttime==0 || $nowtime-$lasttime>=$timeout){
			//#已过期|重新缓存时间
			file_put_contents($cacheFile,$nowtime);
			return true;
		}else{
			//#未过期
			return false;
		}
	}
}
?>
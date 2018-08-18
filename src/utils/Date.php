<?php 
namespace qing\utils;
/**
 * 日期格式化
 * 
 * @see strtotime - 将任何字符串的日期时间描述解析为 Unix 时间戳/strtotime("+1 day")/strtotime("2009-01-31 +1 month")
 * @see mktime - 取得一个日期的 Unix 时间戳/mktime(0, 0, 0, 1, 1, 1998)
 * @see DateTime - DateTime类
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0 all rights reserved.
 */
class Date{
	/**
	 * 友好样式
	 * ---
	 * 刚刚
	 * 1秒前
	 * 1分钟前
	 * 1小时前
	 * 昨天 11:13
	 * 05-12 11:13
	 * 
	 * # 注意
	 * - 今天/昨天的算法： 不能使用24小时时间差计算，当前1点和昨天23点只相差2个小时
	 * 
	 * @param $time 时间戳
	 */
	public static function format($time){
		//现在的时间
		$currTime=time();
		//时间差
		$diffTime=(int)($currTime-$time);
		if($diffTime<10800){
			//#3小时以内/3600*3
			if($diffTime<10){
				//刚刚:10秒以前
				return '刚刚';
			}elseif($diffTime<60){
				//时间差60内/一分钟内/多少秒
				return $diffTime.'秒前';
			}elseif($diffTime<3600){
				//时间差一个小时内/多少分钟
				$diff=(int)($diffTime/60);
				return $diff.'分钟前';
			}else{
				//大于1小时，小于3小时
				$diff=(int)($diffTime/3600);
				return $diff.'小时前';
			}
		}elseif($diffTime<172800){
			//3小时后，2天内/3600*24*2
			//相隔天数/如果等于0则同一天
			$diffDay=(int)date("d",$currTime)-(int)date("d",$time);
			if($diffDay==0){
				//今天 20:52
				return '今天 '.date('H:i',$time);
			}elseif($diffDay==1){
				//昨天 20:52
				return '昨天 '.date('H:i',$time);
			}else{
				//前天 1月7日
				return date("m月d日 H:i",$time);
			}
		}else{
			//2天后
			//相隔年份/如果等于0则同一年
			$diffYear=(int)date("Y",$currTime)-(int)date("Y",$time);
			if($diffYear==0){
				//同年
				return date("m月d日 H:i",$time);
			}else{
				//不同年
				return date("Y-m-d H:i",$time);
			}
		}
	}
	/**
	 * 简单风格
	 * 
	 * @param $time
	 */
	public static function simple($time){
		return date("Y-m-d H:i:s",$time);
	}
}
?>
<?php 
namespace qing\filesystem;
/**
 * 文件大小比特值格式化
 * 单位格式化
 * 单位转换
 * 
 * Byte->KB->MB->GB->TB
 * 
 * @see round-对浮点数进行四舍五入
 * 		float round ( float $val [, int $precision ] )
 * 		根据指定精度 precision（十进制小数点后数字的数目）进行四舍五入的结果
 * 
 * @name conv
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FileSize{
	/**
	 * 自动确定适合的单位
	 * 比特值自动格式化
	 *
	 * dump(FileSize::format(150*1024));
	 * dump(FileSize::format(15000*1024*1024));
	 * 
	 * @param number $size      需要格式化的值；注意是bytes;1024byte=1kb
	 * @param string $returnArr 字符串/数组
	 */
	public static function autoFormat($size,$returnArr=false){
		$units=['B','KB','MB','GB','TB','PB'];
		$count=count($units);
		//size<1,size最终是个小数
		for($i=0;$size>=1024 && $i<$count;$i++){
			$size=$size/1024;
		}
		if(!$returnArr){
			return round($size,2).' '.$units[$i];
		}else{
			return [round($size,2),$units[$i]];
		}
	}
	/**
	 * 格式化比特值到某个单位
	 * 
	 * FileSize::format(1500*1024,'KB')
	 * FileSize::format(1500*1024,'MB')
	 * 
	 * @param number $size 文件大小/单位byte比特
	 * @param string $unit 要转换为指定单位/KB/MB
	 * @return string/array
	 */
	public static function format($size,$unit='',$returnArr=false){
		if(!$unit){
			//自动获取单位
			return self::autoFormat($size,$returnArr);
		}
		$unit=strtoupper($unit);
		$units=['B','KB','MB','GB','TB','PB'];
		$index=array_search($unit,$units);
		if($index===false){
			//指定单位不存在，使用默认
			$index=2;
			$unit ='MB';
		}
		for($i=0;$i<$index;$i++){
			$size=$size/1024;
		}
		if(!$returnArr){
			return round($size,2).' '.$units[$index];
		}else{
			return [round($size,2),$units[$index]];
		}
	}
}
?>
<?php 
namespace qing\filesystem;
/**
 * 文件名格式化
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FileName{
	/**
	 * 截取文件名称，限制字符长度
	 * 以/ \ DS分隔符为截取点
	 * $pattern='/^(.*)\\\\.{50,}/i';
	 * 
	 * @param string $filename 文件名
	 * @param string $length   限制文件名长度
	 * @return string
	 */
	public static function sub($filename,$length=50){
		$ds     =DS;
		$pattern="/^(.*){$ds}{$ds}.{{$length},}/";
		$match=preg_match($pattern,$filename,$matches);
		if(!(bool)$match){
			return $filename;
		}
		$filename=substr($filename,strlen($matches[1]));
		return '...'.$filename;
	}
}
?>
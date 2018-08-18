<?php 
namespace qing\validator;
/**
 * 字符串长度验证器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class StrLenX2{
	/**
	 * 截取字符串，全角半角都占设置长度的一位；支持中文，不会有乱码
	 * 
	 * @param string $value
	 * @param number $min
	 * @param number $max
	 * @param string $charset
	 * @return boolean
	 */
	public static function v_iconv_strlen($value,$min,$max,$charset='utf-8'){
		$len=iconv_strlen($value,$charset);
		if($len>=$min && $len<=$max){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * //测试时文件的编码方式要是UTF8
	 * $str='中文a字1符';
	 * echo strlen($str).'<br>';//14
	 * echo mb_strlen($str,'utf8').'<br>';//6
	 * echo mb_strlen($str,'gbk').'<br>';//8
	 * echo mb_strlen($str,'gb2312').'<br>';//10
	 * --------------------------------------------
	 * 1.字母和数字占位1
	 * 2.中文占位1
	 * 
	 * @param string $value
	 * @param number $min
	 * @param number $max
	 * @param string $charset
	 * @return mixed
	 */
	public static function v_mb_strlen($value,$min,$max,$charset='utf-8'){
		$len=mb_strlen($value,$charset);
		if($len>=$min && $len<=$max){
			return true;
		}else{
			return false;
		}
	}
}
?>
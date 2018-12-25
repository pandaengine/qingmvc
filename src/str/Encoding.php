<?php
namespace qing\str;
/**
 * 字符编码转换
 * 
 * - iconv: 系统默认激活扩展
 * - mb_string: 默认未激活扩展，不过更加稳定？
 * 
 * "ASCII",'UTF-8',"GB2312","GBK",'BIG5'
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Encoding{
	/**
	 * 自动检测字符编码
	 *
	 * @param string $value
	 */
	public static function detect($value,array $encodings=['UTF-8','GB2312','GBK','BIG5']){
		return mb_detect_encoding($value,$encodings);
	}
	/**
	 * 编码转换
	 * 
	 * # iconv 
	 * //IGNORE，不能以目标字符集表达的字符将被默默丢弃。 否则，会导致一个 E_NOTICE并返回 FALSE。
	 * //TRANSLIT，将启用转写（transliteration）功能。
	 *  	这个意思是，当一个字符不能被目标字符集所表示时，它可以通过一个或多个形似的字符来近似表达。
	 *  
	 * @param string $value
	 * @param string $from
	 * @param string $to
	 * @return string
	 */
	public static function conv($value,$from='GB2312',$to='UTF-8'){
		if(function_exists('mb_convert_encoding')){
			//mb_string要手动开启
			return mb_convert_encoding($value,$to,$from);
		}else if(function_exists('iconv')){
			//iconv默认开启，但包含中文时不稳定
			return iconv($from,$to.'//IGNORE',$value);
		}else{
			throw new \Exception('不支持编码转换');
		}
	}
	/**
	 * 编码转换，自动侦测原始编码
	 *
	 * @param string $value
	 * @param string $to
	 * @return string
	 */
	public static function conv_auto($value,$to='UTF-8'){
		//自动侦测原始编码
		$from=mb_detect_encoding($value,['UTF-8','GB2312','GBK','BIG5']);
		if($from!=$to){
			$value=mb_convert_encoding($value,$to,$from);
		}
		return $value;
	}
	/**
	 * 编码转换为utf8
	 *
	 * @param string $value
	 * @param string $from
	 * @return string
	 */
	public static function toUtf8($value,$from='GB2312'){
		return self::conv($value,$from,'UTF-8');
	}
	/**
	 * @param string $value
	 * @param string $from
	 * @return string
	 */
	public static function toGbk($value,$from='UTF-8'){
		return self::conv($value,$from,'GBK');
	}
}
?>
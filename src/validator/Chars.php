<?php 
namespace qing\validator;
use qing\str\Chars as StrChars;
/**
 * 字符数,字符个数，不考虑占用字节
 * Character count
 * 字符个数，中文/字母/数字均只占一个字符
 * 
 * @notice 和占用字节数不同无关
 * @name CharNum
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Chars{
	/**
	 *
	 * @param string $value
	 * @param number $min
	 * @param number $max
	 * @param string $charset
	 * @return mixed
	 */
	public static function validate($value,$min,$max,$charset='utf-8'){
		$len=StrChars::num($value,$charset);
		if($len>=$min && $len<=$max){
			return true;
		}else{
			return false;
		}
	}
}
?>
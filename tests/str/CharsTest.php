<?php
namespace qtests\str;
use qtests\TestCase;
use qing\str\Chars;
/**
 * 字符个数，中文/字母/数字均只占一个字符
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CharsTest extends TestCase{
    /**
     * 字符个数
     */
    public function test(){
    	//测试时文件的编码方式要是UTF8
    	$str='中文a字1符';
    	//3*4+2,utf8汉字占3个字节
    	//字符串字节占用和字符个数的不同
    	$this->assertTrue(strlen($str)==14);
    	//utf8
    	$this->assertTrue(Chars::num($str)==6);
    	$this->assertTrue(Chars::num($str,'utf8')==6);
    	$this->assertTrue(Chars::num($str,'gbk')==8);
    	$this->assertTrue(Chars::num($str,'gb2312')==10);

    	//#iconv_strlen
    	//iconv_strlen要转换编码时，不稳定
    	$this->assertTrue(iconv_strlen($str)==6);
//     	$this->assertTrue(iconv_strlen($str,'utf-8')==6);
//     	$this->assertTrue(iconv_strlen($str,'GBK')==8);
//     	$this->assertTrue(iconv_strlen($str,'gb2312')==10);

    	//#mb_strlen
    	$this->assertTrue(mb_strlen($str,'utf8')==6);
    	$this->assertTrue(mb_strlen($str,'gbk')==8);
    	$this->assertTrue(mb_strlen($str,'gb2312')==10);
    }
    /**
     * 截取字符，不会乱码
     * 截取字符串，全角半角都占设置长度的一位；支持中文，不会有乱码
     */
    public function testSub(){
    	$str="一1二2三3四4五5六6七7八8九9十0;；";//22
    	//utf8汉字占3个字节
    	$this->assertTrue(Chars::num($str)==22);
    	$this->assertTrue(substr($str,0,3)=='一');
    	$this->assertTrue(substr($str,0,4)=='一1');
    	//
    	$this->assertTrue(mb_substr($str,0,1)=='一');
    	$this->assertTrue(mb_substr($str,0,2)=='一1');
    	$this->assertTrue(mb_substr($str,0,3)=='一1二');
    	//编码后再截取
    	//
    	$this->assertTrue(Chars::sub($str,0,1)=='一');
    	$this->assertTrue(Chars::sub($str,0,2)=='一1');
    	$this->assertTrue(Chars::sub($str,0,3)=='一1二');
    }
}
?>
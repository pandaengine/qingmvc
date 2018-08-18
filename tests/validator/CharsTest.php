<?php
namespace qtests\validator;
use qtests\TestCase;
use qing\validator\Chars;
use qing\str\Chars as StrChars;
/**
 * 字符个数，中文/字母/数字均只占一个字符
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CharsTest extends TestCase{
    /**
     * 
     */
    public function test(){
    	//测试时文件的编码方式要是UTF8
    	$str='中文a字1符';
    	$this->assertTrue(StrChars::num($str)==6);
    	$this->assertTrue(Chars::validate($str,6,6));
    	$this->assertFalse(Chars::validate($str,0,5));
    	
    	$str="一1二2三3四4五5六6七7八8九9十0;；";//22
    	$this->assertTrue(StrChars::num($str)==22);
    	$this->assertTrue(Chars::validate($str,22,22));
    	$this->assertFalse(Chars::validate($str,0,21));
    }
}
?>
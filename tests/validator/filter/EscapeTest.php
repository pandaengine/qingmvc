<?php
namespace qtests\validator\filter;
use qtests\TestCase;
use qing\validator\filter\Escape;
// use qing\validator\filter\Slash;
// use qing\validator\filter\Quotes;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class EscapeTest extends TestCase{
    /**
     * - 单引号（'）
	 * - 双引号（"）
	 * - 反斜线（\）与
	 * - NUL（NULL 字符）。
     */
    public function test(){
    	//echo Escape::filter('1\'2"3\\4null5\06null7nul8','138');echo "\n";
    	
    	$this->assertTrue(Escape::filter('1\'2"3\\4null5\06null7nul8')=='1\\\'2\\"3\\\\4null5\\\\06null7nul8');
    	$this->assertTrue(Escape::filter('1\'2"3\\4null5\06null7nul8','138')=='\\1\\\'2\\"\\3\\\\4null5\\\\06null7nul\\8');
    	
    	//反斜杠符号\
    	
    }
}
?>
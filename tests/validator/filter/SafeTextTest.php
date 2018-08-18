<?php
namespace qtests\validator\filter;
use qtests\TestCase;
use qing\validator\filter\SafeText;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SafeTextTest extends TestCase{
    /**
     */
    public function test(){
    	$str='\'\'""\\--==*&^%$#@! \<>?\/[](){}\/:*?"<>|<b>123<b/>';
    	$str2='&#039;&#039;&quot;&quot;\\\\--==*&amp;^%$#@! \\\\?\\\\/[](){}\\\\/:*?&quot;|123';
    	//file_put_contents(__DIR__.'/~log.md', SafeText::filter($str)."\n",FILE_APPEND);
    	
    	$this->assertTrue(SafeText::filter($str)==$str2);
    }
}
?>
<?php
namespace qtests\forms;
use qtests\TestCase;
use qing\form_control\FormControl;
/**
 * 字符个数，中文/字母/数字均只占一个字符
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FormControlTest extends TestCase{
    /**
     * 字符个数
     */
    public function test(){
    	$c=FormControl::radio('name','1');
    	//file_put_contents(__DIR__.'/~log.md',$c,FILE_APPEND);
    	$this->assertContains('type="radio"',$c);
    }
}
?>
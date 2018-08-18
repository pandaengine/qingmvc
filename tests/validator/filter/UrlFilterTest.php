<?php
namespace qtests\validator\filter;
use qtests\TestCase;
use qing\validator\filter\Url;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UrlFilterTest extends TestCase{
    /**
     * 
     */
    public function test(){
    	$url='http://qingmvc.com/path/a/b/c';
    	$this->assertTrue(Url::filter($url)==$url);
    	
    	$url='http://qingmvc.com/path/a/b/c?name=nnn&age=37&code=2';
    	$this->assertTrue(Url::filter($url)==$url);

    	$url='http://qingmv+c.com';
    	$this->assertTrue(Url::filter($url)=='');
    	
    	$url ='http://qingmvc.com/path/a/b/c/<b>123</b>/\'\"$-_.+<>(),{}|\^~[]`\\/;/:@&=?name=nnn&age=37&code=2&b=<b>123</b>-\'\"$-_.+<>(),{}|\^~[]`\\/;/?:@&=';
    	$url2='http://qingmvc.com/path/a/b/c/123/&#039;\\&quot;$-_.+(),{}|\\^~[]`\\/;/:@&amp;=?name=nnn&age=37&code=2&b=%3Cb%3E123%3C%2Fb%3E&e2=';
    	//echo Url::filter($url);
    	//$this->assertTrue(Url::filter($url)==$url2);
    }
}
?>
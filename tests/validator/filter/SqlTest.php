<?php
namespace qtests\validator\filter;
use qtests\TestCase;
use qing\validator\filter\Sql;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SqlTest extends TestCase{
    /**
     * 转义特殊符号，' " \ NULL
     * 转义sql like相关字符 '_' '%'
     */
    public function test(){
    	$str='\'\'""\d11_%2<>?/-+*';
    	$str2='\\\'\\\'\\"\\"\\\\d11_%2<>?/-+*';
    	$str3='\\\'\\\'\\"\\"\\\\d11\\_\\%2<>?/-+*';
    	
    	$this->assertTrue(Sql::filter($str)==$str2);
    	$this->assertTrue(Sql::filter($str,true)==$str3);//like
    	
    	//file_put_contents(__DIR__.'/~logsql.md', $str."\n",FILE_APPEND);
    	//file_put_contents(__DIR__.'/~logsql.md', Sql::filter($str)."\n",FILE_APPEND);
    	//file_put_contents(__DIR__.'/~logsql.md', Sql::filter($str,true)."\n",FILE_APPEND);
    }
}
?>
<?php
namespace qtests\validator;
use qtests\TestCase;
use qing\validator\SafePath;
use qing\validator\filter\SafePath as SafePathFilter;
/**
 * \/:*?"<>|
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SafePathTest extends TestCase{
    /**
     * 
     */
    public function test(){
    	$this->assertTrue(!SafePath::validate('*'));
    	$this->assertTrue(!SafePath::validate('\\'));
    	
    	$this->assertTrue(SafePath::validate('/a/b/b/哈哈/()/-+=/%$#'));
    	$this->assertTrue(SafePath::validate('\a\b\b\哈哈\()\-+=\%$#','\\'));
    }
    /**
     *
     */
    public function testFilter(){
    	$this->assertTrue(SafePathFilter::filter('*')=='');
    	$this->assertTrue(SafePathFilter::filter('\\')=='');
    	 
    	$this->assertTrue(SafePathFilter::filter('/a/哈哈/()/-+=/%$#/\:*?"<>|')=='/a/哈哈/()/-+=/%$#/');
    	$this->assertTrue(SafePathFilter::filter('\a\哈哈\()\-+=\%$#\/:*?"<>|','\\')=='\a\哈哈\()\-+=\%$#\\');
    }
}
?>
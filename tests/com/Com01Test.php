<?php
namespace qtests\com;
use qing\facades\Coms;
use main\coms\Demo01;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Com01Test extends Base{
    /**
     * 
     */
    public function test(){
    	/*@var $demo01 \qtests\coms\Demo01 */
    	$demo01=Coms::get('demo01');
    	//dump($demo01);
    	//dump(Coms::getInstance());
    	$this->assertTrue(is_object($demo01) 
    			&& $demo01 instanceof Demo01
				&& $demo01->name=='xiaowang');
    	//
    	/*@var $demo01 \qtests\coms\Demo01 */
    	$demo0101=Coms::get('demo0101');
    	//dump($demo0101);
    	$this->assertTrue(is_object($demo0101)
    			&& $demo0101 instanceof Demo01
    			&& $demo0101->name=='qingmvc');
    	
    	//两个不同的组件
    	$this->assertTrue($demo01!=$demo0101);
    }
}
?>
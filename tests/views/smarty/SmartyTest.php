<?php
namespace qtests\views\smarty;
use qtests\TestCase;
use qing\facades\Coms;
use qing\mv\ModelAndView;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SmartyTest extends TestCase{
	/**
	 *
	 */
	protected function mv(){
		$vars=[];
		$vars['Name']		='xiaowang';
		$vars['FirstName']	=['f1','f2','f3'];
		$vars['LastName']	=['L1','L2','L3'];
		return new ModelAndView('index.tpl',$vars);
	}
    /**
     * 
     */
    public function test(){
    	if(!class_exists('\Smarty')){
    		//没有手动载入smarty
    		//必须设置smarty文件
    		$this->assertTrue(isset($GLOBALS['SmartyFile']));
    	}
    	//配置视图组件
    	Coms::set('view',
    	[
    		'class'		 =>'\qing\views\Smarty',
    		'smartyFile' =>(string)@$GLOBALS['SmartyFile'],
    		'templateDir'=>__DIR__.'/templates',
    		'configDir'	 =>__DIR__.'/configs',
    		//是否debug
    		'debugging'	 	=>false,
    		'force_compile'	=>false,
    		'caching'	 	=>true,
    		'cache_lifetime'=>120
    	]);
    	/* @var $smarty \qing\views\Smarty */
    	$smarty=Coms::get('view');
    	$content=$smarty->render($this->mv());
    	//file_put_contents(__DIR__.'/log.log',$content);
    	$this->assertTrue($content==file_get_contents(__DIR__.'/index.c.tpl'));
    }
    /**
     *
     */
    public function testCreator(){
    	if(!class_exists('\Smarty')){
    		//没有手动载入smarty
    		//必须设置smarty文件
    		$this->assertTrue(isset($GLOBALS['SmartyFile']));
    		require_once $GLOBALS['SmartyFile'];
    	}
    	Coms::set('smarty',
    	[
    		'creator'	 =>__NAMESPACE__.'\SmartyCreator',
    	]);
    	Coms::remove('view');
    	Coms::set('view',
    	[
    		'class'=>'\qing\views\SmartyView'
    	]);
    	$smarty=Coms::get('smarty');
    	$this->assertTrue(is_object($smarty) && $smarty instanceof \Smarty);
//     	dump($smarty);
    	
    	$view=Coms::get('view');
    	$content=$view->render($this->mv());
    	//file_put_contents(__DIR__.'/log.log',$content);
    	$this->assertTrue($content==file_get_contents(__DIR__.'/index.c.tpl'));
    }
}
?>
<?php
namespace qtests\db;
use qing\facades\Model;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class WhereBase extends Base{
	/**
	 * 测试用例开始
	 */
	protected function setUp(){
		parent::setUp();
		$table=QTESTS_TABLE;
		//#insert插入测试数据
		$res=Model::table($table)->insert(['title'=>'xiaowang1','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==1);//1
		$res=Model::table($table)->insert(['title'=>'xiaowang2','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==2);//2
		$res=Model::table($table)->insert(['title'=>'xiaowang3','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==3);//3
		$res=Model::table($table)->insert(['title'=>'qingmvc4','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==4);//4
	}	
}
?>
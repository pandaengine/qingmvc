<?php
namespace qtests\db;
use qing\facades\Where;
use qing\facades\Model;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Where03Test extends WhereBase{
	/**
	 * 字符串设置
	 */
	public function test(){
		$table=QTESTS_TABLE;
		$where=Where::gleft()
		->sql('title like "%wang_"')
		->sql('id>1')
		->a_n_d('id<=3')
		->a_n_d('id in (1,2,3)')
		->a_n_d('addtime>0')
		->gright()
		->o_r('title like "%mvc%"');
		
		//dump($where);
		//dump($where->getWhere());
		//dump($where->getBindings());
		//return;
		
		$res=Model::table($table)->where($where)->select();
		$this->assertTrue(count($res)==3 && $res[0]['id']==2 && $res[1]['id']==3 && $res[2]['id']==4);//2,3,4
		//dump(Model::getInstance());
	}
}
?>
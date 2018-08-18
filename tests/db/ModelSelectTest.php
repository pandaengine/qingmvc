<?php
namespace qtests\db;
use qing\facades\Model;
/**
 * 模型查询操作测试
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ModelSelectTest extends Base{
	/**
	 * 测试用例开始
	 */
	protected function setUp(){
		parent::setUp();
		$table=QTESTS_TABLE;
		
		//#insert插入测试数据
		$res=Model::table($table)->insert(['uid'=>1,'num'=>1,'title'=>'xiaowang1','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==1);//1
		$res=Model::table($table)->insert(['uid'=>1,'num'=>2,'title'=>'xiaowang2','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==2);//2
		$res=Model::table($table)->insert(['uid'=>2,'num'=>3,'title'=>'xiaowang3','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==3);//3
		$res=Model::table($table)->replace(['uid'=>3,'num'=>4,'title'=>'xiaowang4','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==4);//4
	}
	/**
	 * 尽可能多的测试所有参数
	 */
	public function test(){
		$table=QTESTS_TABLE;
		//
		$this->assertTrue(Model::table($table)->count()==4);
		
		//查找数据一行
		$res=Model::table($table)->fields('*')->where(['id'=>1])->orderby('addtime desc')->limit('0,2')->select();
		$this->assertTrue(count($res)==1 && $res[0]['id']==1);//1
		//查找多行数据,先排序再选择两行
		$res=Model::table($table)->fields('*')->where('id>0')->orderby('id desc')->limit('0,2')->select();
		$this->assertTrue(count($res)==2 && $res[0]['id']==4);//4
		
		//#groupby
		$res=Model::table($table)->fields('*,count(*) as c,sum(num) as nums')->where('id>0')->orderby('id asc')->limit('0,4')
								 ->groupby('uid')->select();
		//dump($res);dump(Model::getSql());
		$this->assertTrue(count($res)==3 && $res[0]['id']==1 && $res[0]['c']==2 && $res[0]['nums']==3);//1
		
		//#having
		$res=Model::table($table)->fields('*,count(*) as c,sum(num) as nums')->where('id>0')->orderby('id asc')->limit('0,4')
								 ->groupby('uid')->having('nums=3')->select();
		//dump($res);dump(Model::getSql());
		$this->assertTrue(count($res)==2 && $res[1]['id']==3 && $res[1]['c']==1 && $res[1]['nums']==3);//1
		
	}
}
?>
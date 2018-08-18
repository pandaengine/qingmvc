<?php
namespace qtests\db;
use qing\facades\Model;
/**
 * 模型链式操作测试
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ModelTest extends Base{
	/**
	 */
	public function test(){
		$table=QTESTS_TABLE;
		
		//#insert插入数据
		$res=Model::table($table)->insert(['title'=>'xiaowang','addtime'=>time()]);
		//dump($res);
		$this->assertTrue(is_int($res) && $res==1);//1
		
		$res=Model::table($table)->insert(['title'=>'xiaowang','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==2);//2
		
		//#count统计数据
		$res=Model::table($table)->count();
		//dump($res);
		$this->assertTrue($res==2);
		
		//#replace，插入
		$res=Model::table($table)->replace(['title'=>'xiaowang','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==3);//3
		//替换，已经有三条记录,1,2,3
		$res=Model::table($table)->replace(['id'=>2,'title'=>'xiaowang2','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==2);//替换了 id=2的记录
		//查找数据一行
		$res=Model::table($table)->fields('title')->where(['id'=>2])->findField('title');
		$this->assertTrue($res=='xiaowang2');//xiaowang2
		
		//#删除数据
		$res=Model::table($table)->where(['id'=>1])->delete();
		$this->assertTrue($res);
		$this->assertTrue(Model::table($table)->count()==2);
		$res=Model::table($table)->where(['id'=>2])->delete();
		$this->assertTrue($res);
		$this->assertTrue(Model::table($table)->count()==1);
	}
	/**
	 * 尽可能多的测试所有参数
	 */
	public function testSelect(){
		$table=QTESTS_TABLE;
		
		//#insert插入测试数据
		$res=Model::table($table)->insert(['title'=>'xiaowang1','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==1);//1
		$res=Model::table($table)->insert(['title'=>'xiaowang2','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==2);//2
		$res=Model::table($table)->replace(['title'=>'xiaowang3','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==3);//3
		
		//
		$this->assertTrue(Model::table($table)->count()==3);
		
		//查找数据一行
		$res=Model::table($table)->fields('*')->where(['id'=>1])->orderby('addtime desc')->limit('0,2')->select();
		$this->assertTrue(count($res)==1 && $res[0]['id']==1);//1
		//查找多行数据,先排序再选择两行
		$res=Model::table($table)->fields('*')->where('id>0')->orderby('id desc')->limit('0,2')->select();
		$this->assertTrue(count($res)==2 && $res[0]['id']==3);//3
		//
	}
	/**
	 * 尽可能多的测试所有参数
	 */
	public function testUpdate(){
		$table=QTESTS_TABLE;
		//#insert插入测试数据
		$res=Model::table($table)->insert(['title'=>'xiaowang','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==1);//1
		$res=Model::table($table)->insert(['title'=>'xiaowang','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==2);//2
		//
		$res=Model::table($table)->where(['id'=>1])->find();
		$this->assertTrue(is_array($res) && $res['title']=='xiaowang' && $res['num']==0);
		
		//#更新操作/数组
		$res=Model::table($table)->where(['id'=>1])->update(['title'=>'xiaowang2','num'=>2]);
		$res=Model::table($table)->where(['id'=>1])->find();
		$this->assertTrue(is_array($res) && $res['title']=='xiaowang2' && $res['num']==2);
		
		//自增自减
		$res=Model::table($table)->where(['id'=>1])->set(' title="xiaowang3",num=3 ')->update();
		$res=Model::table($table)->where(['id'=>1])->find();
		$this->assertTrue(is_array($res) && $res['title']=='xiaowang3' && $res['num']==3);
		//
		$res=Model::table($table)->where(['id'=>1])->inc('num');
		$res=Model::table($table)->where(['id'=>1])->find();
		$this->assertTrue(is_array($res) && $res['num']==4);
		//
		$res=Model::table($table)->where(['id'=>1])->dec('num');
		$res=Model::table($table)->where(['id'=>1])->find();
		$this->assertTrue(is_array($res) && $res['num']==3);
		
	}
	/**
	 * - 有重复异常则更新某些字段;否则插入
	 * - id主键或unique字段重复则更新
	 * 
	 * num =num+3			//原始记录的值自加3
	 * num =VALUES(num)+3   //取得插入的值自加3
	 * 
	 */
	public function testInsertUpdate(){
		$table=QTESTS_TABLE;
		//#insert插入测试数据
		$res=Model::table($table)->insert(['title'=>'xiaowang','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==1);//1
		$res=Model::table($table)->insert(['title'=>'xiaowang','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==2);//2
	
		//新插入
		$res=Model::table($table)->insertUpdate(['title'=>'xiaowang3','addtime'=>time()],['addtime']);
		$this->assertTrue(is_bool($res) && $res);
		$this->assertTrue(Model::getInsertId()==3);//3
		
		//
		$this->assertTrue(Model::table($table)->count()==3);//3
		
		//冲突更新,id=1,
		//ON DUPLICATE KEY UPDATE title=VALUES(title),addtime=VALUES(addtime)
		$res=Model::table($table)->insertUpdate(['id'=>1,'title'=>'xiaowang1','addtime'=>1],['title','addtime']);
		$this->assertTrue(is_bool($res) && $res);
		$this->assertTrue(Model::getInsertId()==1);
		//
		$res=Model::table($table)->where(['id'=>1])->find();
		$this->assertTrue(is_array($res) && $res['title']=='xiaowang1' && $res['addtime']==1);
		
		//#
		$res=Model::table($table)->insertUpdate(['id'=>1,'title'=>'xiaowang2','addtime'=>222],'title=VALUES(title),addtime=addtime+10 ');
		$this->assertTrue(is_bool($res) && $res);
		$this->assertTrue(Model::getInsertId()==1);
		//
		$res=Model::table($table)->where(['id'=>1])->find();
		$this->assertTrue(is_array($res) && $res['title']=='xiaowang2' && $res['addtime']==11);
		
		//
		$this->assertTrue(Model::table($table)->count()==3);//3
		
	}
}
?>
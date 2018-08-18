<?php
namespace qtests\db;
use qing\facades\Where;
use qing\facades\Model;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Where02Test extends WhereBase{
	/**
	 * 不绑定预处理参数
	 */
	public function test(){
		$bindOn=false;
		$table=QTESTS_TABLE;
		//查找
		$res=Model::table($table)->where(['id'=>1])->select();
		$this->assertTrue(count($res)==1 && $res[0]['id']==1);//1
		//in查找
		$res=Model::table($table)->where(' id in (1,3)')->select();
		$this->assertTrue(count($res)==2 && $res[0]['id']==1 && $res[1]['id']==3);//1,3
		//in
		$where=Where::in('id',[2,3]);
		$res=Model::table($table)->where($where)->select();
		$this->assertTrue(count($res)==2 && $res[0]['id']==2 && $res[1]['id']==3);//2,3
		
		//like
		$res=Model::table($table)->where(' id<=2 and title like "xiaowang_" ')->select();
		$this->assertTrue(count($res)==2 && $res[0]['id']==1 && $res[1]['id']==2);//1,2
		
		//like,通配符/单字符 : % _
		$res=Model::table($table)->where(' id>1 and title like "%wang_" ')->select();
		$this->assertTrue(count($res)==2 && $res[0]['id']==2 && $res[1]['id']==3);//2,3
		
		//like
		$where=Where::le('id',2)->like('title','xiaowang_');
		$res=Model::table($table)->where($where)->select();
		$this->assertTrue(count($res)==2 && $res[0]['id']==1 && $res[1]['id']==2);//1,2
		
		//like,通配符/单字符 : % _
		$where=Where::gt('id',1)->like('title','%wang_');
		$res=Model::table($table)->where($where)->select();
		$this->assertTrue(count($res)==2 && $res[0]['id']==2 && $res[1]['id']==3);//2,3
	}
	/**
	 * 字符串设置
	 */
	public function testString(){
		$table=QTESTS_TABLE;
		$where=Where::gleft()
		->set('title','%wang_','like')
		->set('id',1,'>')
		->set('id',3,'<=')
		->set('id',[1,2,3],'in')
		->set('addtime',0,'>')
		->gright()
		->set('title','%mvc%','like','or');
		//克隆实例,使用过后数据被清空
		$whereClone=clone $where;
		$this->assertContains('(  title like ? and id > ? and id <= ? and id in (?,?,?) and addtime > ?  ) or title like ?',$whereClone->getWhere());
		//sql
		//$res=Model::table($table)->where($whereClone);
		//$sql=$this->privateMethod(Model::getInstance(),'buildSql',['select']);
		//dump($sql);
		$res=Model::table($table)->where($where)->select();
		$this->assertTrue(count($res)==3 && $res[0]['id']==2 && $res[1]['id']==3 && $res[2]['id']==4);//2,3,4
		//dump($where);
		//dump($where->getWhere());
		//dump(Model::getInstance());
	}
	/**
	 */
	public function test03(){
		$table=QTESTS_TABLE;
		$where=Where::gleft()
		->like('title','%wang_')
		->gt('id',1)
		->le('id',3)
		->in('id',[1,2,3])
		->gt('addtime',0)
		->gright()
		->like('title','%mvc%','or');
		//
		$res=Model::table($table)->where($where)->select();
		$this->assertTrue(count($res)==3 && $res[0]['id']==2 && $res[1]['id']==3 && $res[2]['id']==4);//2,3,4
	}
}
?>
<?php
namespace qtests\db\lock;
use qtests\db\Base as DbBase;
use qing\facades\Model;
use qing\db\ddl\Lock;
use qing\utils\ClassName;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Base extends DbBase{
	/**
	 * - 截断表
	 * - 插入测试数据 
	 */
	protected function setUp(){
		parent::setUp();
	}
	/**
	 * 插入测试数据 
	 * 
	 * @param string $table
	 */
	protected function initData($table=QTESTS_TABLE){
		//#主连接插入测试数据
		$res=Model::table($table)->insert(['title'=>'t1','name'=>'n1','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==1);//1
		$res=Model::table($table)->insert(['title'=>'t2','name'=>'n2','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==2);//2
		$res=Model::table($table)->insert(['title'=>'t3','name'=>'n3','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==3);//3
		$res=Model::table($table)->insert(['title'=>'t4','name'=>'n4','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==4);//4
		$res=Model::table($table)->insert(['title'=>'t5','name'=>'n5','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==5);//5
		$res=Model::table($table)->insert(['title'=>'t6','name'=>'n6','addtime'=>time()]);
		$this->assertTrue(is_int($res) && $res==6);//6
	}
	/**
	 * @param string $table
	 */
	protected function lock_tables_write($table=QTESTS_TABLE){
		return Lock::lock_table_write($table);
	}
	/**
	 * @param string $table
	 */
	protected function lock_tables_read($table=QTESTS_TABLE){
		return Lock::lock_table_read($table);
	}
	/**
	 */
	protected function unlock_tables(){
		return Lock::unlock_tables();
	}
	/**
	 * 表锁
	 * Pdo Execute Error: 1099:Table 'pre_tests_myisam' was locked with a READ lock and can't be updated
	 *
	 * @param \qing\db\Connection $conn
	 * @param boolean $res
	 */
	protected function isTableLockRead($conn,$res){
		if($res===false){
			$error=$conn->getError();
			return preg_match('/.*?1099.*?locked.*?READ\s+lock.*/i',$error)>0;
		}else{
			return false;
		}
	}
	/**
	 * @param number $real 真实时间
	 * @param number $about 大概时间
	 * @param number $range
	 * @return string
	 */
	protected function runtimeRange($real,$about,$range=0.5){
		$real=(float)$real;
		$about=(float)$about;
		if($real>$about && $real<=($about+$range)){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * @param string $file
	 * @return boolean
	 */
	protected function finish_time_log($file){
		$file=ClassName::onlyName($file);
		file_put_contents(__DIR__.'/~'.$file.'.log',microtime(true));
	}
	/**
	 * @param string $file
	 * @return boolean
	 */
	protected function finish_time_check($file){
		$file=ClassName::onlyName($file);
		$time=file_get_contents(__DIR__.'/~'.$file.'.log');
		//after，在它之后即可，等待那个用例执行完，当前用例才执行
		return microtime(true)>$time;
	}
}
?>
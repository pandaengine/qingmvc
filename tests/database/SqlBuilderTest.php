<?php
namespace qtests\database;
use qtests\TestCase;
use qing\db\SqlBuilder;
use qing\db\Model;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SqlBuilderTest extends TestCase{
	/**
	 */
	public function test(){
		$model=new Model();
		$sqlBuiler=new SqlBuilder();
		$sqlBuiler->bindOn=true;
		$sqlBuiler->type='mysql';
		$sqlBuiler->initComponent();
		//find
		$model->table('table')->where(['id'=>1,'uid'=>11])->limit('0,1');
		$parts=$this->privateProperty($model,'_parts');
		$sql=$sqlBuiler->buildSql('SELECT',$parts);
		$binds=$sqlBuiler->getBindings();
		/*
		var_dump($model);
		var_dump($parts);
		var_dump($sqlBuiler);
		var_dump($sql);
		var_dump($binds);
		*/
		//dump($sql);
		//$this->assertContains('SELECT * FROM table WHERE  `id`=? AND `uid`=?     LIMIT 0,1',$sql);
		$this->assertTrue(preg_match('/SELECT \* FROM table WHERE  `id`=\? AND `uid`=\?\s+LIMIT 0,1\s*/i',$sql)>0);
		$this->assertEquals([1=>1,2=>11],$binds);
		
	}
}
?>
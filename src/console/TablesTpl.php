<?php
namespace qing\console;
/**
 * 根据数据表生成表名，表字段配置提示文件
 * 子类继续并设置tables属性
 * 
 * @notice 要想重新生成，需要删除lock.txt文件
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class TablesTpl extends Command{
	use traits\DbTrait;
	/**
	 * @var string
	 */
	protected $prefix;
	/**
	 * @var boolean
	 */
	protected $fieldsOn=false;
	/**
	 * 数据库连接
	 *
	 * @var string
	 */
	public $connName='';
	/**
	 * 执行命令
	 * 
	 * @param ArgumentBag $args
	 * @return boolean
	 */
	public function run(ArgumentBag $args){
		$this->fieldsOn=$args->option('fields',false);
		$this->connName=$args->option('conn','');
		//
		$cacheName='~tips.tables';
		$this->connName>'' && $cacheName.='.'.$this->connName;
		//
		$cacheFile=APP_RUNTIME.DS.$cacheName.'.php';
		//
		$this->prefix=$this->getConn()->getPrefix();
		$tables=(array)$this->getTables();
		
		$content='';
		$content.=$this->buildTables($tables);
		if($this->fieldsOn){
			$content.=$this->buildFields($tables);
		}
		$content.=$this->buildTClass($tables);
		//
		file_put_contents($cacheFile,'<?php'."\n".$content."\n".'?>');		
		return true;
	}
	/**
	 * @param array $tables
	 * @return string
	 */
	protected function buildTables(array $tables){
		$content='';
		//#
		foreach($tables as $table){
			$table=$this->getTableName($table);
			$tableName='TB_'.strtoupper($table);
			$content.="define('{$tableName}'\t,'{$table}');\n";
		}
		return $content."\n";
	}
	/**
	 * @param array $tables
	 * @return string
	 */
	protected function buildFields(array $tables){
		$content='';
		//#
		foreach($tables as $table){
			//#获取字段数据
			$fields=(array)$this->getTableFields($table);
			$fields=implode(',',$fields);
			//
			$table=$this->getTableName($table);
			$tableName='FE_'.strtoupper($table);
			$content.="define('{$tableName}'\t,'{$fields}');\n";
		}
		return $content;
	}
	/**
	 * @param array $tables
	 * @return string
	 */
	protected function buildTClass(array $tables){
		$content="\nclass T{\n";
		//
		foreach($tables as $table){
			$table=$this->getTableName($table);
			$content.="\tconst {$table}='{$table}';\n";
		}
		$content.="\n";
		//
		if($this->fieldsOn){
			foreach($tables as $table){
				//#获取字段数据
				$fields=(array)$this->getTableFields($table);
				$fields=implode(',',$fields);
				//
				$table=$this->getTableName($table);
				$content.="\tconst f_{$table}='{$fields}';\n";
			}
		}
		$content.="}\n";
		return $content;
	}
	/**
	 * 剔除前缀
	 * 
	 * @param string $table
	 */
	protected function getTableName($table){
		return preg_replace('/^'.$this->prefix.'/i','',$table);
	}
}
?>
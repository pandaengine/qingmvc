<?php
namespace qing\dbx;
use qing\interceptor\Interceptor;
use qing\filesystem\MK;
use qing\db\Db;
/**
 * 数据库备份拦截器
 * 
 * - 定义不同的拦截器，设置不同的数据库连接，可以备份多个数据库连接
 * - 
 * 
 * # 重新备份
 * 要想重新备份，需要删除lock.txt文件
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class DbBackupInterceptor extends Interceptor{
	/**
	 * 数据库连接
	 * - 包括默认数据库名称
	 * - 可以访问多个数据库
	 * 
	 * @var string default/uid
	 */
	public $connName;
	/**
	 * 备份所以数据库
	 * 否则只备份conn连接中默认的数据库
	 *
	 * @var array
	 */
	public $databaseAll=false;
	/**
	 * 数据库名
	 * 为空则备份全部数据库
	 *
	 * @var array
	 */
	public $databases=[];
	/**
	 * 排除系统数据库
	 *
	 * @var array
	 */
	public $databasesEx=['performance_schema','information_schema'];
	/**
	 * 是否备份表结构
	 *
	 * @var boolean
	 */
	public $tableOn=true;
	/**
	 * 是否备份数据
	 *
	 * @var boolean
	 */
	public $dataOn=false;
	/**
	 * 限制数据最大行数，避免数据过多
	 *
	 * @var boolean
	 */
	public $limitRows=0;
	/**
	 * 总是重新生成
	 *
	 * @var boolean
	 */
	public $aways=false;
	/**
	 * @var string
	 */
	protected $cachePath;
	/**
	 * @var DbBackupModel
	 */
	protected $model;
	/**
	 * @see \qing\interceptor\Interceptor::preHandle()
	 */
	public function preHandle(){
		$cachePath=$this->cachePath=APP_RUNTIME.DS.'~db.backup';
		if(!$this->aways){
			//#检测是否已经锁定
			$lockFile=$cachePath.DS.'lock.txt';
			if(is_file($lockFile)){
				//#已锁定，不更新
				return true;
			}
		}
		MK::dir($cachePath);
		//conn
		!$this->connName && $this->connName=KEY_MAIN;
		if(!Db::has($this->connName)){
			throw new \Exception('数据库连接不存在:'.$this->connName);
		}
		//model
		$this->model=new DbBackupModel();
		$this->model->connName($this->connName);
		//备份的数据库
		if($this->databases){
			//指定的数据库
			$dbs=(array)$this->databases;
		}else{
			//自动获取
			if($this->databaseAll){
				//所有数据库
				$dbs=(array)$this->model->allDatabases();
			}else{
				//连接的默认库
				$dbs=[Db::conn($this->connName)->name];
			}
		}
		foreach($dbs as $dbName){
			$this->backupDatabase($dbName);
		}
		if(!$this->aways){
			//#生成锁定文件
			file_put_contents($lockFile,date('Y-m-d H:i:s',time()));
		}
		return true;
	}
	/**
	 * 备份一个数据库
	 * 
	 * @param string $dbName
	 */
	protected function backupDatabase($dbName){
		if(in_array($dbName,$this->databasesEx)){
			return;
		}
		$model=$this->model;
		$tables_all=$model->allTables($dbName);
		$struct	="";
		$data	="";
		foreach($tables_all as $realtable){
			//真实表名|包括库名|`qingcms2014`.`pre_user`
			$realtable="`{$dbName}`.`$realtable`";
			if((bool)$this->tableOn){
				//#导出表结构
				$struct.=$model->backupTable($realtable);
			}
			if((bool)$this->dataOn){
				//#导出表数据
				$data.=$model->backupData($realtable,$this->limitRows);
			}
		}
		//保存
		if($struct){
			$this->saveCache($dbName,$struct,'table');
		}
		if($data){
			$this->saveCache($dbName,$data,'data');
		}
	}
	/**
	 * 保存备份文件
	 *
	 * @param string $dbName
	 * @param string $content
	 * @param string $type
	 */
	protected function saveCache($dbName,$content,$type){
		$fileName=$this->cachePath.DS."{$dbName}.{$type}.".date('Ymd.Hi').".sql";
		file_put_contents($fileName,$content);
	}
}
?>
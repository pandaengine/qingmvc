<?php
namespace qing\forms;
use qing\interceptor\Interceptor;
use qing\tips\traits\DbTrait;
use qing\tips\Utils;
use qing\filesystem\MK;
/**
 * 表单字段过滤器
 * - 要想重新生成，需要删除lock.txt文件
 * 
 * @notice 要想重新生成，需要删除lock.txt文件
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FilterBuilderInterceptor extends Interceptor{
	use DbTrait;
	/**
	 * @var string
	 */
	public $classSuffix='Filter';
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
	 * @see \qing\interceptor\Interceptor::preHandle()
	 */
	public function preHandle(){
		$cacheName='~forms.filters';
		if($this->connName>''){ $cacheName.='.'.$this->connName; }
		//
		$this->cachePath=APP_RUNTIME.DS.$cacheName;
		MK::dir($this->cachePath);
		//
		if(!$this->aways){
			//#检测是否已经锁定
			$lockFile=$this->cachePath.DS.'lock.txt';
			if(is_file($lockFile)){
				//#已锁定，不更新
				return true;
			}
		}
		//
		$tables=$this->getTables();
		//#
		$builder=new FilterBuilder();
		//#
		foreach($tables as $realTable){
			$this->build($builder,$realTable);
		}
		//
		if(!$this->aways){
			//#生成锁定文件
			file_put_contents($lockFile,date('Y-m-d H:i:s',time()));
		}
		return true;
	}
	/**
	 * @param \qing\rowb\FilterBuilder $builder
	 * @param string $realTable
	 */
	protected function build($builder,$realTable){
		//#获取字段数据
		list($fields,$types,$comments)=$res=$this->getFields($realTable);
		//
		$namespace=app()->namespace.'\forms';
		//#剔除前缀
		$prefix=$this->getConn()->getPrefix();
		$className=preg_replace('/^'.$prefix.'/i','',$realTable);
		$className=Utils::getClassName($className);//驼峰法
		$className=$className.$this->classSuffix;
		//#
		$builder->types($types);
		$builder->comments($comments);
		$content=$builder->build($fields,$className,$namespace);
		//#保存
		$this->save($className,$content);
	}
	/**
	 *
	 * @param string $filename
	 * @param string $content
	 */
	protected function save($className,$content){
		$newfile=$this->cachePath.DS.'~'.$className.'.php';
		file_put_contents($newfile,$content);
	}
}
?>
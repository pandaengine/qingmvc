<?php
namespace qing\tips;
use qing\interceptor\Interceptor;
use qing\filesystem\MK;
/**
 * 根据数据表，生成模型提示辅助文件
 * 
 * @notice 要想重新生成，需要删除lock.txt文件
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ModelsBuilderInterceptor extends Interceptor{
	use traits\DbTrait;
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
	protected $prefix;
	protected $namespace;
	/**
	 * @see \qing\interceptor\Interceptor::preHandle()
	 */
	public function preHandle(){
		$cachePath=$this->cachePath=APP_RUNTIME.DS.'~tips.models';
		if(!$this->aways){
			//#检测是否已经锁定
			$lockFile=$cachePath.DS.'lock.txt';
			if(is_file($lockFile)){
				//#已锁定，不更新
				return true;
			}
		}
		//
		$this->prefix	=$this->getConn()->getPrefix();
		$this->namespace=main()->namespace.'\model';
		//#创建缓存目录
		MK::dir($cachePath);
		//数据表列表
		$tables=(array)$this->getTables();
		foreach($tables as $realTable){
			$this->build($realTable);
		}
		//
		if(!$this->aways){
			//#生成锁定文件
			file_put_contents($lockFile,date('Y-m-d H:i:s',time()));
		}
		return true;
	}
	/**
	 * 创建一个表，一个模型
	 * 
	 * @param string $realTable
	 */
	protected function build($realTable){
		$fields=$this->getTableFields($realTable);
		//#剔除前缀
		$tableName=preg_replace('/^'.$this->prefix.'/i','',$realTable);
		$className=Utils::getClassName($tableName);
		//
		$theme=
		"<?php\n{namespace}\n".
		"/**\n *\n *\n */\n".
		'class {class} extends \qing\db\Model{'."\n".
		'{table}'.
		'{fields}'.
		'}'."\n".
		'?>';
		$vars=[];
		$vars['{namespace}']	=Utils::getNamespace($this->namespace);
		$vars['{class}']		='_'.$className;
		$vars['{table}']		=$this->build_tableName($tableName);
		$vars['{fields}']		=$this->build_fieldsStr($fields);
		/*@see qreplace */
		$content=strtr($theme,$vars);
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
	/**
	 * 遍历各个属性
	 *
	 * @param array $fields
	 */
	protected function build_fieldsStr(array $fields){
		$values =implode(',',$fields);
		return "\tpublic \$fields='{$values}';\n";
	}
	/**
	 * @param string $tableName
	 */
	protected function build_tableName($tableName){
		$content="\tpublic \$tableName='{$tableName}';\n";
		$content.="\tpublic \$tableName_Const=TB_".strtoupper($tableName).";\n";
		$content.="\tpublic \$tableName_T=T::{$tableName};\n";
		$content.="\tpublic \$fields_T=T::f_{$tableName};\n";
		return $content;
	}
}
?>
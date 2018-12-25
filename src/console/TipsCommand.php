<?php
namespace qing\console;
use qing\filesystem\MK;
use qing\filesystem\Scan;
use qing\utils\ClassName;
use qing\exceptions\NotfoundDirException;
/**
 * 提示类生成工具
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class TipsCommand extends Command{
	/**
	 * 类名
	 * [[className,id]]
	 *
	 * @var array
	 */
	public $classes=[];
	/**
	 *
	 * @var array
	 */
	public $cachePath='';
	/**
	 * 执行命令
	 * 
	 * @param ArgumentBag $args
	 * @return boolean
	 */
	public function run(ArgumentBag $args){
		$this->cachePath=APP_RUNTIME.DS.'~tips';
		MK::dir($this->cachePath);
		
		//dump(__METHOD__);
		//dump($args);
		//global $argc,$argv;dump($argv);exit();
		
		$classes=[];
		if(!is_null($class=$args->option('class',null))){
			//#指定类名/--class={class}
			//--class={namespace}|{dirname}
			$exp=explode('|',$class);
			if(isset($exp[1])){
				//生成目录
				$this->_initDirs($classes,$exp[0],$exp[1]);
			}else{
				$classes[]=[$class,$class];
			}
		}else if(!is_null($comId=$args->option('com',null))){
			//#指定组件/--com={com}
			$com=coms()->get($comId);
			$classes[]=[get_class($com),$comId];
		}else if($args->option('coms')===true){
			//#所有组件/--coms
			$this->_initComs($classes);
		}
		
		//是否生成组件
		//$this->coms && $this->initComponents();
		//目录
		//$this->dirs && $this->initDirs();
		//
		foreach($classes as $row){
			$this->build($row[1],$row[0]);
		}
		return true;
	}
	/**
	 * @param array $classes
	 */
	protected function _initComs(array &$classes){
		//组件
		$coms=(array)coms()->getServices();
		foreach($coms as $id=>$cfg){
		//排除module@/itct@
			if(preg_match('/^(module|itct)\@/',$id)>0){
				continue;
			}
			try{
			//获取组件，解决creator无法获取类名的情况
				$com=coms()->get($id);
			}catch(\Exception $e){
				throw $e;
			}
			$classes[]=[get_class($com),$id];
		}
	}
	/**
	 * @param array $classes
	 * @param string $namespace
	 * @param string $dirName
	 */
	protected function _initDirs(array &$classes,$namespace,$dirName){
		if(!is_dir($dirName)){
			$dirName=main()->getBasePath().DS.$dirName;
			if(!is_dir($dirName)){
				throw new NotfoundDirException($dirName);
			}
		}
		$files=Scan::files($dirName,'/\.php$/i');
		foreach($files as $file){
			$file=rtrim($file,'\.php');//不区分大小写
			$className=$namespace.'\\'.$file;
			if(class_exists($className)){
				$classes[]=[$className,$file];
			}
		}
	}
	/**
	 * @param string $comId
	 * @param string $className 类肯定存在
	 */
	protected function build($comId,$className){
		if(!$comId){ $comId=$className; }
		//$shortClass=Utils::getShortClassName($className);
		list($namespace,$shortClass)=ClassName::format($className);
		$tpl=
		"<?php\n{namespace}\n".
		"exit('do not use it! only for tip! '.__FILE__);\n".
		"/**\n *\n * @see {$className}\n */\n".
		'class {class} extends Facade{'."\n".
		'{name}'.
		'{instance}'.
		'{methods}'.
		'}'."\n".
		'?>';
		$vars=[];
		$vars['{namespace}']	=Utils::getNamespace($namespace);
		$vars['{class}']		='_'.$shortClass;
		$vars['{instance}']		=$this->_getInstance($className);
		$vars['{name}']			=$this->_getName($comId);
		$vars['{methods}']		=$this->_getMethods($className);
		/*@see qreplace */
		$content=strtr($tpl,$vars);
		
		//保存缓存
		file_put_contents($this->cachePath.'/'.$shortClass.'.tips.php',$content);
	}
	/**
	 *
	 * @param string $className
	 */
	protected function _getInstance($className){
		$code=
		"\t/**\n".
		"\t * 获取组件 \n\t * \n".
		"\t * @return {$className} \n\t */\n".
		"\tpublic static function getInstance(){\n".
		"\t\t\n".
		"\t}\n";
		return $code;
	}
	/**
	 *
	 * @param string $name
	 */
	protected function _getName($name){
		$code=
		"\t/**\n".
		"\t * 组件id \n\t * \n".
		"\t * @return string \n\t */\n".
		"\tpublic static function getName(){\n".
		"\t\treturn '{$name}';\n".
		"\t}\n";
		return $code;
	}
	/**
	 * @param array $parameters
	 */
	protected function _getParameters(array $parameters,$withDef=false){
		$content='';
		foreach($parameters as $param){
			/*@var $param \ReflectionParameter */
			$name=$param->getName();
			if($content>''){
				$content.=',';
			}
			$content.='$'.$name;
			//默认值
			if($withDef && $param->isDefaultValueAvailable()){
				$def=$param->getDefaultValue();
				if(is_array($def)){
					$def='[]';
				}else if(is_int($def)){
				}else{
					$def="'{$def}'";
				}
				$content.='='.$def;
			}
		}
		return $content;
	}
	/**
	 * @param string $field
	 */
	protected function _getMethods($className){
		$content='';
		$refClass=new \ReflectionClass($className);
		$methods=$refClass->getMethods(\ReflectionMethod::IS_PUBLIC);
		foreach($methods as $method){
			/*@var $method \ReflectionMethod */
			$name=$method->getName();
			/*
			if($method->class!=$refClass->getName()){
				continue;
			}
			*/
			if($name[0]=='_'){
				continue;
			}
			if($name=='initComponent'){
				continue;
			}
			$content.=$this->_getMethod($name,$method);
		}
		return $content;
	}
	/**
	 * @param string $field
	 * @param \ReflectionMethod $parameters
	 */
	protected function _getMethod($field,$method){
		$params=$this->_getParameters($method->getParameters(),true);
		$params2=$this->_getParameters($method->getParameters(),false);
		$tpl=
		"\t/**\n\t * \n\t */\n".
		"\tpublic static function {$field}({$params}){\n".
		"\t\treturn static::getInstance()->{$field}({$params2});\n".
		"\t}\n";
		return $tpl;
	}
}
?>
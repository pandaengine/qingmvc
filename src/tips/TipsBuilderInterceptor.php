<?php
namespace qing\tips;
use qing\interceptor\Interceptor;
use qing\filesystem\MK;
use qing\filesystem\Scan;
use qing\utils\ClassName;
/**
 * 提示类生成工具拦截器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class TipsBuilderInterceptor extends Interceptor{
	/**
	 * 是否生成组件
	 *
	 * @var array
	 */
	public $coms=false;
	/**
	 * 类名
	 * [[className,id]]
	 * 
	 * @var array
	 */
	public $classes=
	[
		['\qing\db\BaseModel',''],
		['\qing\db\Model','']
	];
	/**
	 * 目录
	 * [[dirpath,namespace]]
	 *
	 * @var array
	 */
	public $dirs=[];
	/**
	 *
	 * @var array
	 */
	public $cachePath='';
	/**
	 */
	protected function initComponents(){
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
			$this->classes[]=['\\'.get_class($com),$id];
		}
	}
	/**
	 */
	protected function initDirs(){
		foreach($this->dirs as $dir){
			list($dirname,$namespace)=$dir;
			$files=Scan::files($dirname,'/\.php$/i');
			foreach($files as $file){
				$file=rtrim($file,'\.php');//不区分大小写
				$className=$namespace.'\\'.$file;
				if(class_exists($className)){
					$this->classes[]=[$className,$file];
				}
			}
		}
	}
	/**
	 * @see \qing\interceptor\Interceptor::preHandle()
	 */
	public function preHandle(){
		$this->cachePath=APP_RUNTIME.DS.'~tips';
		MK::dir($this->cachePath);
		//是否生成组件
		$this->coms && $this->initComponents();
		//目录
		$this->dirs && $this->initDirs();
		//
		foreach($this->classes as $row){
			$this->build($row[1],$row[0]);
		}
		return true;
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
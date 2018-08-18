<?php
namespace qing\autoload;
/**
 * 类自动加载器
 * 
 * - ['qing',''] 只支持一段命名空间
 * - ['qing\utils',''] 不支持多段命名空间
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ClassLoader{
	/**
	 * @return ClassLoader
	 */
	public static function sgt($className=__CLASS__){
		return Loader::sgt($className);
	}
	/**
	 * 是否已经被注册
	 *
	 * @var bool
	 */
	protected $registered=false;
	/**
	 * 命名空间对应目录
	 * 
	 * @var array
	 */
	protected $namespaces=[];
	/**
	 * 目录分隔符是否是反斜杠
	 * 如果不是反斜杠则需要替换，一致性原则
	 * 
	 * - 命名空间分隔符: \
	 * - 目录分隔符: win \ linux /
	 * 
	 * @see DIRECTORY_SEPARATOR
	 * @var array
	 */
	protected $dsReplace=false;
	/**
	 * 创建类别名加载器实例
	 *
	 * @return void
	 */
	public function __construct(){
		$this->register();
	}
	/**
	 * 注册这个类加载器到自动加载栈
	 * 
	 * - spl_autoload_register可以注册多个处理方法
	 * - spl_autoload_extensions('.inc,.php,.qing');
	 * 
	 * @return void
	 */
	protected function register(){
		if(!$this->registered){
			//#spl默认的autoload函数spl_autoload会在找不到的最后寻找当前目录下的文件|只允许.php后缀
			spl_autoload_extensions('.php');
			spl_autoload_register(array($this,'autoload'));
			$this->dsReplace =('\\'!=DIRECTORY_SEPARATOR);
			$this->registered=true;
		}
	}
	/**
	 * 类自动加载器
	 *
	 * 注意：
	 * is_callable(class),
	 * class_exists(class)均会触发该方法，自动包含类文件
	 *
	 * @throws 不能抛出任何异常，  否则class_exists判断将无意义
	 * @param  string $fullClassName  首部没有斜杠|qing\test\XXX
	 * @return boolean
	 */
	protected function autoload($fullClassName){
		//取出命名空间和类名|[qing,a\b\Qing]
		list($first,$other)=$res=Loader::getNSFirstPart($fullClassName);
		if(isset($this->namespaces[$first])){
			if($this->dsReplace){
				//命名空间分隔符替换成目录分隔符
				$other=str_replace('\\',DIRECTORY_SEPARATOR,$other);
			}
			$classFile=$this->namespaces[$first];
			$classFile=$classFile.DIRECTORY_SEPARATOR.$other.'.php';
			$classFile=realpath($classFile);
			if(is_file($classFile)){
				//#预处理类文件
				require_once $classFile;
				return true;
			}
		}
		return false;
	}
	/**
	 * 添加类命名空间片段和目录的映射
	 * 后添加的会覆盖前面的
	 * 
	 * @param string $namespace 首部没有斜杠|qing\test\XXX
	 * @param string $path		目录路径
	 * @throws \Exception
	 */
	public function addNamespace($namespace,$path){
		$namespace=trim($namespace,'\\');
		if(!preg_match('/^[a-z0-9_]+$/i',$namespace)){
			throw new \Exception('namespace only number and letter, can only contain one part "'.$namespace.'" ');
		}
		if(!($realpath=realpath($path))){
			throw new \Exception('path not exists '.$path);
		}
		$this->namespaces[$namespace]=$realpath;
	}
	/**
	 * @param array $list
	 */
	public function addNamespaces(array $list){
		foreach ($list as $namespace=>$path){
			$this->addNamespace($namespace,$path);
		}
	}
}
?>
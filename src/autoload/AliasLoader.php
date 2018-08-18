<?php
namespace qing\autoload;
/**
 * 类别名自动加载器
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class AliasLoader{
	/**
	 * @return AliasLoader
	 */
	public static function sgt($className=__CLASS__){
		return Loader::sgt($className);
	}
	/**
	 * 类别名信息
	 * 
	 * @var array
	 */
	protected $aliases;
	/**
	 * 加载器是否已经被注册
	 *
	 * @var bool
	 */
	protected $registered=false;
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
	 * #spl_autoload_register ($autoload_function = null, $throw = null, $prepend = null)
	 * #$prepend: If true, spl_autoload_register will prepend[加在开始处] the autoloader on the autoload stack instead of appending[在尾部添加] it.
	 * ##spl_autoload_register(array($this,'autoload'),true,true);
	 * 
	 * @return void
	 */
	protected function register(){
		if(!$this->registered){
			spl_autoload_register(array($this,'autoload'));
			$this->registered=true;
		}
	}
	/**
	 * 加载某个别名的实例，如果已经别名对应类已经实例化
	 * class_alias：为一个类创建别名
	 * 
	 * #class_alias ($original, $alias, $autoload = null)
	 * ##original：原始的类名
	 * ##alias   ：类的别名
	 * ##autoload：Whether do autoload if the original class is not found
	 * 
	 * @autoload:不能抛出任何异常
	 * @param string $alias 类别名/找不到文件的类名
	 * @return void
	 */
	protected function autoload($alias){
		if(isset($this->aliases[$alias])){
			//根据别名获取原始类名
			$oriClass=$this->aliases[$alias];
			//创建类别名
			//true:原始类不存在则触发autoload自动加载,会加载类
			return class_alias($oriClass,$alias,true);
		}
		return false;
	}
	/**
	 * 添加一个类别名到加载器
	 * 
	 * @param string $alias    类的别名
	 * @param string $original 原始类名
	 * @return void
	 */
	public function addAlias($alias,$original){
		$this->aliases[$alias]=$original;
	}
	/**
	 * 添加多个类别名到加载器
	 * 
	 * @param  array $list
	 * @return void
	 */
	public function addAliases(array $list){
		foreach($list as $alias=>$original){
			$this->addAlias($alias,$original);
		}
	}
}
?>
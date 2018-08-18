<?php 
namespace qing\lang;
/**
 * 支持对象或者静态方法
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class L{
	/**
	 * 语言组件，用于对象方法
	 *
	 * @var string
	 */
	public $comName="lang";
	/**
	 * @return string
	 */
	public static function appName(){ return 'QingMVC'; }
	public static function qingmvc(){ return 'QingMVC.PHP { A SIMPLE MVC&OOP PHP FRAMEWORK }'; }
	/**
	 * 组件名称
	 * - 可重写
	 * 
	 * @return string
	 */
	public static function comName(){
		return 'lang';
	}
	/**
	 * @return \qing\lang\Lang
	 */
	public static function com(){
		return coms()->get(static::comName());
	}
	/**
	 * 静态函数的调用魔术方法
	 * constant("self::".$string)|static::appName|调用常量属性
	 * static可以使用子类的属性
	 * ---
	 * L::qingmvc('2015.09.17','abc');
	 * qingmvc  ="QingMVC.PHP { A SIMPLE MVC&OOP PHP FRAMEWORK } %s %s"
	 * 
	 * @param string $prop 	静态函数名
	 * @param string $params  函数参数
	 * @return string
	 */
	public static function __callStatic($prop,array $params=[]){
		return static::com()->get($prop,$params);
	}
	/**
	 * 读取不可访问属性的值时，__get() 会被调用。
	 * 返回组件的属性值,如果属性不存在或不能访问，检测是否存在get方法
	 * 
	 * @param string $key 属性的名称
	 */
	public function __get($key){
		return $this->lang($key);
	}
	/**
	 * 当调用一个不存在的成员方法时触发
	 * 
	 * @param string $key	   方法名称
	 * @param array  $params 方法参数
	 */
	public function __call($key,$params){
		return $this->lang($key,$params);
	}
	/**
	 * @param string $key 要翻译的关键字
	 * @param array $args    函数参数
	 * @return string
	 */
	public function lang($key,array $params=[]){
		/*@var $lang \qing\lang\Lang */
		$lang=com($this->comName);
		return $lang->get($key,$params);
	}
}
?>
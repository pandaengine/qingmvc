<?php
namespace qing\form_control;
/**
 * 表单控件注册器
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FormControl{
	/**
	 * 取得控件实例
	 * 
	 * @param string $type 表单类型|select|radio|text
	 * @return \qing\form_control\Control
	 */
	public static function getControl($type){
		$className=__NAMESPACE__.'\\'.ucfirst($type);
		if(!class_exists($className)){
			throw new \qing\exceptions\NotfoundClassException($className);
		}
		return new $className();
	}
	/**
	 * 渲染表单控件
	 * 
	 * @param string $type  表单类型|select|radio|text
	 * @param string $name  表单域名称|name|email
	 * @param string $value 表单值
	 * @return string
	 */
	public static function render($type,$name,$value){
		$control=self::getControl($type);
		$control->name	=$name;
		$control->value	=$value;
		return $control->render();
	}
	/**
	 * 下拉选框
	 *
	 * @param array  $options
	 * @param string $name
	 * @param string $value
	 * @return string
	 */
	public static function select(array $options,$name,$value){
		$select=new Select($options);
		$select->options($options)->name($name)->value($value);
		return $select->render();
	}
	/**
	 * 下拉选框|按键值对映射
	 *
	 * @param array  $options
	 * @param string $name
	 * @param string $value
	 * @return string
	 */
	public static function selectkv(array $options,$name,$value){
		$select=new SelectKv($options);
		$select->options($options)->name($name)->value($value);
		return $select->render();
	}
	/**
	 * 单选框
	 *
	 * @see Radio
	 * @param string $name
	 * @param string $value
	 * @return string
	 */
	public static function radio($name,$value){
		return self::render('Radio',$name,$value);
	}
	/**
	 * textarea
	 *
	 * @param string $name
	 * @param string $value
	 * @return string
	 */
	public static function textarea($name,$value){
		return self::render('Textarea',$name,$value);
	}
}
?>
<?php 
namespace qing\debug;
/**
 * 表单模拟器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Form{
	/**
	 * emulation
	 * 表单仿真器
	 * get表单，post表单
	 */
	public static function create($fields,$values,$action="#",$method="get",$return=false){
		$from=" <form action='{$action}' method='{$method}' target='_blank' >\n";
		if(!is_array($fields)) $fields=explode(",", $fields);
		if(!is_array($values)) $values=explode(",", $values);
		foreach ($fields as $k=>$field){
			$from.="{$field}: <input type='text' name='{$field}' value='".$values[$k]."' /> <br/>\n";
		}
		$from.="<input type='submit' value='submit' />\n</form>\n";
		if($return===false){
			echo $from;
		}else{
			return $from;
		}
	}
	/**
	 * emulation
	 * 表单仿真器
	 * get表单，post表单
	 *
	 * @param array  $datas		表单数据
	 * @param string $action
	 * @param string $method
	 * @param string $return
	 * @return string
	 */
	public static function byArray(array $datas,$action="#",$method="get",$return=false){
		$from=" <form action='{$action}' method='{$method}' target='_blank' >\n";
		foreach ($datas as $name=>$value){
			$from.="{$name}: <input type='text' name='{$name}' value='{$value}' /> <br/>\n";
		}
		$from.="<input type='submit' value='submit' />\n</form>\n";
		if($return===false){
			echo $from;
		}else{
			return $from;
		}
	}
}
?>
<?php
namespace qing\safe;
use qing\interceptor\Interceptor;
use qing\validator\filter\SafeText;
/**
 * 安全模式，拦截器
 * 过滤所有用户提交数据
 * 
 * @see $_REQUEST/$_GET/$_POST/$_COOKIE/$_FILES
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SafeModeInterceptor extends Interceptor{
	/**
	 * 开启安全模式
	 *
	 * @var bool
	 */
	public $enable=false;
	/**
	 * 要重置的超全局变量
	 * - 不设置则不处理
	 * - 清除cookie会导致session不可用
	 *
	 * @var array ['get','cookie']
	 */
	public $resetVars=[];
	/**
	 * 要清理数据的超全局变量
	 * - 不设置则不处理
	 * - 如果已经reset重置，则不需要再clear了
	 * 
	 * @var array
	 */
	public $filterVars=[];
	/**
	 * 
	 * @see \qing\interceptor\Interceptor::preHandle()
	 */
	public function preHandle(){
		if($this->enable){
			$this->resetVars();
			$this->filterVars();	
		}
		return true;
 	}
	/**
	 * 
	 */
	protected function resetVars(){
		$resetVars=(array)$this->resetVars;
		if(!$resetVars){
			//不设置则允许所以变量
			return;
		}
		foreach($resetVars as $var){
			$var=strtoupper($var);
			//超全局变量，要用作可变变量，函数和类的内部要使用global
			//把超全局变量的值置空，$_GET=[];
			$var='_'.$var;
			//global ${$var};
			//${$var}=[];
			$GLOBALS[$var]=[];
		}
	}
	/**
	 * 要清理数据的超全局变量
	 * 只需要清理运行的变量即可(不指定允许时是全部变量)
	 */
	protected function filterVars(){
		$filterVars=(array)$this->filterVars;
		if(!$filterVars){
			return;
		}
		foreach($filterVars as $var){
			$var=strtoupper($var);
			//过滤超全局变量的值
			$var='_'.$var;
			$GLOBALS[$var]=$this->filterData($GLOBALS[$var]);
		}
	}
	/**
	 * - 过滤数据
	 * - POST和GET子数据均可能是数组数据
	 *
	 * TODO:键值和值均需要过滤|<b>abc</b>=abc|键值也可以XSS代码
	 *
	 * form[username]:7512e5e6a6
	 * form[gender]:0
	 * form[province]:19
	 * form[city]:289
	 *
	 * @param array $data
	 * @return array
	 */
	protected function filterData(array $data){
		$arr=[];
		foreach($data as $k=>$v){
			if(is_array($v)){
				$v=$this->filterData($v);
			}else{
				$v=SafeText::filter((string)$v);
			}
			$k=SafeText::filter((string)$k);
			$arr[$k]=$v;
		}
		return $arr;
	}
}
?>
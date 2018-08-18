<?php 
namespace qing\url\creators;
use qing\url\Utils;
use qing\com\Component;
use qing\url\UrlInterface;
/**
 * 路由别名生成器
 * - 路由对应 > 别名
 * - u_login_index > login
 * - 设置[模块_控制器_操作]路由的别名
 * 
 * @name RouteAlias 路由别名
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class UrlAlias extends Component implements UrlInterface{
	/**
	 * 分隔符
	 *
	 * @var string
	 */
	const SEPARATOR='@';
	/**
	 * url映射
	 * 注意: 真实url必须全部小写
	 * 
	 * ['真实url'=>'别名']
	 * [
	 * 'login2@index'=>'login2',
	 * 'u@index@index'=>'user',
	 * 'reg@index'=>'reg',
	 * ]
	 * 
	 * @var array
	 */
	protected $_maps=[];
	/**
	 * 根据模块，控制器，操作各个部分生成url
	 *
	 * @param string $module 	模块
	 * @param string $ctrl 		控制器
	 * @param string $action 	操作
	 * @param array  $params 	附加参数
	 * @return string
	 */
	public function create($module,$ctrl,$action,array $params=[]){
		$id=$this->getId($module,$ctrl,$action);
		if(!isset($this->_maps[$id])){
			return false;
		}
		//#映射中取得别名
		$alias=$this->_maps[$id];
		if($alias instanceof \Closure){
			//闭包函数
			//$alias=call_user_func($alias,$params);
			$alias=$alias($params);
		}
		$alias=(string)$alias;
		if($params){
			//#附加的get参数
			$gets=http_build_query($params);
			return Utils::push_query($alias,$gets);
		}else{
			return $alias;
		}
	}
	/**
	 * 三段：包括模块
	 * 两段：不包括模块
	 *
	 * mod_ctrl_action
	 * ctrl_action
	 *
	 * m_u_c_index_a_index
	 * mU_cIndex_aIndex
	 *
	 * @param string $module
	 * @param string $ctrl
	 * @param string $action
	 */
	protected function getId($module,$ctrl,$action){
		$key='';
		if($module && $module!==MAIN_MODULE){
			$key.=$module.self::SEPARATOR;
		}
		if(!$ctrl){
			$ctrl=DEF_CTRL;
		}
		if(!$action){
			$action=DEF_ACTION;
		}
		return strtolower($key.$ctrl.self::SEPARATOR.$action);
	}
	/**
	 *
	 * @param string $url 真实url
	 * @param string $alias url别名
	 */
	public function setMap($url,$alias){
		$this->_maps[$url]=$alias;
	}
	/**
	 * 
	 * @param array $maps
	 */
	public function setMaps(array $maps){
		if($this->_maps){
			$this->_maps=array_merge($this->_maps,$maps);
		}else{
			$this->_maps=$maps;
		}
	}
	/**
	 * 
	 * @param string $key
	 * @return string
	 */
	public function getMap($key){
		return isset($this->_maps[$key])?$this->_maps[$key]:'';
	}
	/**
	 * @return array
	 */
	public function getMaps(){
		return $this->_maps;
	}
}	
?>
<?php
namespace qing\router;
use qing\com\Component;
use qing\url\UrlInterface;
use qing\url\Utils as UrlUtils;
/**
 * 简单的路由别名
 * 路由别名<=>真实路由，双向转换
 * 
 * - 路由解析器，根据别名解析出路由
 * - 路由创建器，根据路由生成别名url
 * - 解析器和创建器一一对应
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Alias extends Component implements ParserInterface,UrlInterface{
	/**
	 * 分隔符
	 * 注意: 以@分割，不要使用_和/
	 * 
	 * @var string
	 */
	public $separator='@';
	/**
	 * url映射
	 * ['路由别名'=>'真实路由']
	 * ['login'=>'login@index']
	 * ['login'=>['login','index']]
	 * 
	 * 
	 * @var array
	 */
	protected $_maps=[];
	/**
	 * 反正maps
	 * ['真实路由'=>'路由别名']
	 *
	 * @var array
	 */
	protected $_rmaps=[];
	/**
	 * 
	 */
	public function __construct(){
	}
	/**
	 * 路由解析
	 * 应用生命周期只使用一次
	 * 
	 * @see \qing\router\ParserInterface::match()
	 */
	public function parse(){
		if(!$this->_maps){ return false; }
		//#pathinfo段
		//$pathinfo=Request::getPathInfo();
		$pathinfo=(string)@$_SERVER['PATH_INFO'];
		if(!$pathinfo){
			return ParserInterface::INDEX;
		}
		$pathinfo=trim($pathinfo,'/');
		if(!isset($this->_maps[$pathinfo])){
			return false;
		}
		$route=$this->_maps[$pathinfo];
		if(is_array($route)){
			$route=Utils::byArr($route);
		}else{
			$route=Utils::byStr((string)$route,$this->separator);
		}
		//路由只会解析一次，释放内存？创建路由还需要
		return Utils::toBag($route);
	}
	/**
	 * 路由创建，url创建
	 * 创建路由的别名
	 * 
	 * @param string $module 	模块
	 * @param string $ctrl 		控制器
	 * @param string $action 	操作
	 * @param array  $params 	附加参数
	 * @return string
	 */
	public function create($module,$ctrl,$action,array $params=[]){
		if(!$this->_maps){
			return false;
		}
		if(!$this->_rmaps){
			$this->formatRMaps();
		}
		$id=$this->getId($module,$ctrl,$action);
		if(!isset($this->_rmaps[$id])){
			return false;
		}
		$url=$this->_rmaps[$id];
		if($params){
			//#附加的get参数
			$gets=http_build_query($params);
			$url=$url.'?'.$gets;
		}
		return '/'.$url;
	}
	/**
	 *
	 * @see array_flip - 交换数组中的键和值
	 * 	注意 array 中的值需要能够作为合法的键名（例如需要是 integer 或者 string）。
	 * 	如果类型不对，将出现一个警告，并且有问题的键／值对将不会出现在结果里。
	 * 	如果同一个值出现多次，则最后一个键名将作为它的值，其它键会被丢弃。
	 */
	protected function formatRMaps(){
		//$this->_rmaps=array_flip($this->_maps);
		foreach($this->_maps as $alias=>$route){
			//格式化真实的路由
			if(is_array($route)){
				//数组转字符串
				$route=Utils::byArr($route);
			}else{
				//字符串
				$route=Utils::byStr($route,$this->separator);
			}
			if(count($route)==3 && $route[0]==MAIN_MODULE){
				//移除主模块，保持一直
				unset($route[0]);
			}
			$route=implode($this->separator,$route);
			$this->_rmaps[$route]=$alias;
		}
	}
	/**
	 * 三段：包括模块
	 * mod@ctrl@action
	 *
	 * @param string $module
	 * @param string $ctrl
	 * @param string $action
	 */
	protected function getId($module,$ctrl,$action){
		if(!$action){
			$action=DEF_ACTION;
		}
		if(!$module || $module==MAIN_MODULE){
			//2段
			return strtolower($ctrl.$this->separator.$action);
		}else{
			//3段
			return strtolower($module.$this->separator.$ctrl.$this->separator.$action);
		}
	}
	/**
	 *
	 * @param string $alias 路由别名
	 * @param string $route 真实路由
	 */
	public function setMap($alias,$route){
		$this->_maps[$alias]=$route;
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
<?php 
namespace qing\router\parser;
//use qing\facades\Request;
use qing\router\ParserInterface;
use qing\router\RouteBag;
/**
 * PathInfo解析器|和RParser类似
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class PathInfoParser implements ParserInterface{
	/**
	 * 路由参数的键值
	 *
	 * @var string
	 */
	public $keyRoute="r";
	/**
	 * 模块分隔符
	 * #避免盘符(/\""''<>:|?)等|否则htaccess重定向有问题
	 *
	 * @var string
	 */
	public $modSign=R_MODSIGN;
	/**
	 * pathinfo中的path分隔符
	 * 不能和模块分隔符一致！
	 * 
	 * / : index.php/.u/index/index/id/1/name/xiaowang/age/23
	 * - : index.php/.u-index-index-id-1-name-xiaowang-age-23
	 *
	 * @deprecated
	 * @var string
	 */
	public $delimiter=R_DELIMITER;
	/**
	 * 
	 * @see \qing\router\parser\AbsParser::match()
	 */
	/**
	 * 
	 * @return boolean|\qing\router\RouteBag
	 */
	public function parse(){
		$route=$this->getRoute();
		$route=trim($route,'/');
		if(!$route){
			//使用默认路由
			return ParserInterface::INDEX;
		}
		$mod	 ='';
		$ctrl	 ='';
		$action='';
		$arr=(array)explode($this->delimiter,$route);
		//模块
		$_mod=current($arr);
		$modId=preg_quote($this->modSign,'/');
		if(preg_match('/^'.$modId.'(.+)$/',$_mod,$matches)){
			//#匹配到模块|.u/.passport
			array_shift($arr);
			$mod=$matches[1];
		}else{
			$mod=DEF_MODULE;
		}
		$ctrl  =array_shift($arr);
		$action=array_shift($arr);
		if($arr){
			//#多余参数,合并到$_GET
			$this->plusParams($arr);
		}
		if(!$ctrl){
			$ctrl=DEF_CTRL;
		}
		if(!$action){
			$action=DEF_ACTION;
		}
		return new RouteBag($mod,$ctrl,$action);
	}
	/**
	 * index.php?r=/.u/index/index
	 * index.php/.u/index/index
	 * 
	 * @param array $params
	 * @return string
	 */
	protected function getRoute(){
		$key=$this->keyRoute;
		if($key>'' && isset($_GET[$key])){
			//#从查询参数中获取
			return (string)$_GET[$key];
		}
		//#pathinfo段
		//return Request::getPathInfo();
		return (string)@$_SERVER['PATH_INFO'];
	}
	/**
	 * 解析附加参数
	 * 约定: url的数据都合并到$_GET
	 * 
	 * 0  1   2    3
	 * id/123/name/xiaowang
	 * 0  1   0    1        %2
	 *
	 * @param array $params
	 */
	protected function plusParams(array $params){
		foreach($params as $k=>$v){
			if($k%2==0){
				$_GET[$params[$k]]=$params[$k+1];
			}
		}
	}
}
?>
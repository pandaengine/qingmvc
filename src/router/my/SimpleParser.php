<?php 
namespace qing\router\my;
use qing\router\RouteBag;
use qing\router\Parser;
// use qing\facades\Request;
/**
 * 简单的路由处理器
 * 
 * - 字母+数字
 * - note/123->note/index?id=123
 * 
 * 例如
 * - /p/12345
 * - /read/1231
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SimpleParser extends Parser{
	/**
	 * @var string
	 */
	protected $idKey='id';
	/**
	 * @see \qing\router\parser::match()
	 */
	public function parse(){
		//#pathinfo段
		//$pathinfo=Request::getPathInfo();
		$pathinfo=(string)@$_SERVER['PATH_INFO'];
		if(!$pathinfo){
			return false;
		}
		$pathinfo=trim($pathinfo,'/');
		//#/note/123|/read/123|/index2/123
		if(preg_match('/^([a-z0-9]+)\/([0-9]+)$/i',$pathinfo,$matches)){
			$ctrl=$matches[1];
			$id  =(int)$matches[2];
			//#注入get参数
			$_GET[$this->idKey]=$id;
			//#接管路由
			$routebag=new RouteBag('',$ctrl,'index');
		}else{
			$routebag=false;
		}
		return $routebag;
	}
}
?>
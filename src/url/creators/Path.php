<?php
namespace qing\url\creators;
use qing\url\Utils;
use qing\url\UrlInterface;
/**
 * Path生成器
 * 附加参数以querystring形式
 * /.mod/ctrl/action?id=1
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Path implements UrlInterface{
	/**
	 * @see \qing\url\creators\Creator::createUrl()
	 */
	public function create($module,$ctrl,$action,array $params=[]){
		$arr=array();
		if($module>''){
			$arr[]=R_MODSIGN.$module;
		}
		if($ctrl>''){
			$arr[]=$ctrl;
		}
		if($action>''){
			$arr[]=$action;
		}
		$url=Utils::createPathParams($arr);
		if($params){
			$gets=Utils::createGetParams($params);
			$url =$url.'?'.$gets;
		}
		return '/'.$url;
	}
}
?>
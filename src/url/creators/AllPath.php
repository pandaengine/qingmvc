<?php
namespace qing\url\creators;
use qing\url\Utils;
use qing\url\UrlInterface;
/**
 * 所有参数包括附加参数都以path格式
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class AllPath implements UrlInterface{
	/**
	 * 是否是rpath
	 *
	 * @var string
	 */
	public $rpath=false;
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
		//添加附加的属性
		if($params){
			foreach($params as $k=>$v){
				$arr[]=$k;
				$arr[]=$v;
			}
		}
		$url=Utils::createPathParams($arr);
		if($this->rpath){
			return '?r=/'.$url;
		}else{
			return '/'.$url;
		}
	}
}
?>
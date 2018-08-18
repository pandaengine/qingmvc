<?php
namespace qing\url\creators;
use qing\url\Utils;
use qing\url\UrlInterface;
/**
 * Get生成器
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Get implements UrlInterface{
	/**
	 * @see \qing\url\creators\Creator::createUrl()
	 */
	public function create($module,$ctrl,$action,array $params=[]){
		$arr=[];
		if($module>''){
			$arr[RKEY_MODULE]=$module;
		}
		if($ctrl>''){
			$arr[RKEY_CTRL]=$ctrl;
		}
		if($action>''){
			$arr[RKEY_ACTION]=$action;
		}
		if($params){
			$arr=array_merge($arr,$params);
		}
		$gets=Utils::createGetParams($arr);
		return '?'.$gets;
	}
}
?>
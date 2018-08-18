<?php
namespace qing\url\creators;
/**
 * Path生成器
 *
 * @example ?r=/index/index&id=1
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class RPath extends Path{
	/**
	 * 是否是rpath
	 *
	 * @var string
	 */
	public $pathKey='r';
	/**
	 * @see \qing\url\creators\Creator::createUrl()
	 */
	public function create($module,$ctrl,$action,array $params=[]){
		$url=parent::create($module,$ctrl,$action,$params);
		$url=str_replace('?','&',$url);
		return '?'.$this->pathKey.'='.$url;
	}
}
?>
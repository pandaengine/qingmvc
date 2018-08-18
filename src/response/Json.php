<?php 
namespace qing\response;
use qing\http\Response;
/**
 * Json格式响应输出
 * 
 * jsonp/callback:json01({name:xiaowang});
 * json:{name:xiaowang}
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Json extends Response{
	/**
	 * 构造函数
	 *
	 * @param string $url      重定向url
	 * @param string $callback jsonp回调函数
	 * @return void
	 */
	public function __construct(array $data,$callback=''){
		parent::__construct(200);
		if($callback>''){
			$this->byJsonp($data,$callback);
		}else{
			$this->byJson($data);
		}
	}
	/**
	 * json格式
	 * 
	 * @param array  $data json数据
	 */
	protected function byJson($data){
		$this->setContentType('json');
		//content
		$content=json_encode($data,JSON_UNESCAPED_UNICODE);
		$this->setContent($content);
	}
	/**
	 * json格式
	 *
	 * @param array  $data     json数据
	 * @param string $callback json回调函数|json01()
	 */
	protected function byJsonp($data,$callback){
		$this->setContentType('js');
		//content
		$content=json_encode($data,JSON_UNESCAPED_UNICODE);
		$content="{$callback}({$content})";
		$this->setContent($content);
	}
}
?>
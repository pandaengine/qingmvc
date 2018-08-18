<?php 
namespace qing\response;
use qing\http\Response;
/**
 * xml响应
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Xml extends Response{
	/**
	 * xml版本
	 * 
	 * @var string
	 */
	public $version='1.0';
	/**
	 * 根标签
	 * 
	 * @var string
	 */
	public $rootTag='response';
	/**
	 * 选项标签
	 * 
	 * @var string
	 */
	public $itemTag='item';
	/**
	 * 构造函数
	 *
	 * @param array $data
	 * @param int   $status
	 * @return void
	 */
	public function __construct(array $data,$status=200){
		parent::__construct($status);
		//#
		$this->setContentType('xml');
		//
		$dom  = new \DOMDocument($this->version,$this->charset);
		$root = new \DOMElement($this->rootTag);
		$dom->appendChild($root);
		//
		$this->buildXml($root,$data);
		//保存成字符串
		$content=$dom->saveXML();
		$this->setContent($content);
	}
	/**
	 * @param DOMElement 		 $element
	 * @param mixed|array/string $data
	 */
	protected function buildXml($element,array $data){
		foreach($data as $name=>$value){
			if(is_array($value)){
				//创建一个dom元素
				$child=new \DOMElement(is_int($name)?$this->itemTag:$name);
				$element->appendChild($child);
				//递归处理
				$this->buildXml($child,$value);
			}else{
				$child=new \DOMElement(is_int($name)?$this->itemTag:$name);
				$element->appendChild($child);
				$child->appendChild(new \DOMText((string)$value));
			}
		}
	}
}
?>
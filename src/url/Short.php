<?php 
namespace qing\url;
use qing\com\Component;
/**
 * 短链接组件
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Short extends Component{
	/**
	 * url映射
	 * ['短链接'=>'真实地址']
	 * ['login'=>'/login/index']
	 * 
	 * @var array
	 */
	protected $_maps=[];
	/**
	 * @see \qing\com\ComponentInterface::initComponent()
	 */
	public function initComponent(){
	}
	/**
	 *
	 * @param string $short
	 */
	public function get($short){
		return @$this->_maps[$short];
	}
	/**
	 *
	 * @param string $short
	 * @param string $url
	 */
	public function set($short,$url){
		$this->_maps[$short]=$url;
	}
	/**
	 * @param array $maps
	 */
	public function sets(array $maps){
		if($this->_maps){
			$this->_maps=array_merge($this->_maps,$maps);
		}else{
			$this->_maps=$maps;
		}
	}
}	
?>
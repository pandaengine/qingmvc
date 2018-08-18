<?php 
namespace qing\lang;
use qing\com\Component;
/**
 * 国际化，语言翻译组件
 * 
 * @name Language I18n
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Lang extends Component{
	/**
	 * 设置语言 ,zh_cn,zh_tw,en
	 * 设置为空时不处理
	 * 
	 * @var string
	 */
	public $lang="zh_cn";
	/**
	 * 默认语言
	 * 如果当前语言找不到键值的话，从默认语言中获取
	 *
	 * @var string
	 */
	public $langDef="zh_cn";
	/**
	 * lang 目录名称
	 * 
	 * @var string
	 */
	public $langDir='lang';
	/**
	 * lang 目录路径
	 *
	 * @var string
	 */
	public $langPath;
	/**
	 * 已加载的语言数据
	 * 
	 * @var string
	 */
	protected $_langs=[];
	/**
	 * @see \qing\com\Component::initComponent()
	 */
	public function initComponent(){
		//初始化当前语言
		if(!isset($this->_langs[$this->lang])){
			$this->initLang($this->lang);
		}
	}
	/**
	 * 使用到时才创建
	 * 
	 * @param string $lang
	 */
	public function initLang($lang){
		if(isset($this->_langs[$lang])){
			//已经初始化
			return $this->_langs[$lang];
		}
		$this->_langs[$lang]=[];
		//#系统语言
		$qingLang=__DIR__.'/langs/'.$lang.PHP_EXT;
		if(is_file($qingLang)){
			$this->_langs[$lang]=require $qingLang;
		}
		//#应用语言
		if(!$this->langPath){
			$this->langPath=main()->getBasePath().DS.$this->langDir;
		}
		$appLang=$this->langPath.DS.$lang.PHP_EXT;
		if(is_file($appLang)){
			$appLang=require $appLang;
			$this->_langs[$lang]=array_merge($this->_langs[$lang],$appLang);
		}
		return $this->_langs[$lang];
	}
	/**
	 * vsprintf("%d %s",[123,'abc']);
	 * 
	 * @param string $key
	 * @param array $params
	 */
	public function get($key,array $params=[]){
		if(isset($this->_langs[$this->lang][$key])){
			//当前语言
			$lang=$this->_langs[$this->lang][$key];
		}else{
			//默认语言
			if(!isset($this->_langs[$this->langDef])){
				$this->initLang($this->langDef);
			}
			if(isset($this->_langs[$this->langDef][$key])){
				//存在
				$lang=$this->_langs[$this->langDef][$key];
			}else{
				//不存在
				return '::'.$key;
			}
		}
		if($params){
			return vsprintf($lang,$params);
		}else{
			return $lang;
		}
	}
	/**
	 * @param string $key
	 * @param string $value
	 */
	public function set($key,$value){
		
	}
}
?>
<?php 
namespace qing\config;
use qing\com\Component;
/**
 * 用户配置 
 * 全局配置数据帮助类
 * 应用上下文的一些配置
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Config extends Component{
	/**
	 * 应用内一些配置信息
	 * 优点：不同环境会覆盖某个键值
	 * 
	 * @var array/string 数组/文件路径
	 */
	protected $configs=[];
	/**
	 * 配置文件路径
	 * 缺点：不同环境会覆盖整个路径，不能覆盖某个键值
	 * 
	 * @var string 文件路径
	 */
	public $configFile='';
	/**
	 * - 如果使用字符串则提前导入
	 * - 可以使用__APP__等常量
	 * 
	 * @see \qing\com\ComponentInterface::initComponent()
	 */
	public function initComponent(){
		//#合并$configs/$configFile
		if($this->configFile && is_file($this->configFile)){
			$this->configs=array_merge($this->configs,(array)include $this->configFile);
		}
	}
	/**
	 * @param string/array $values
	 */
	public function setConfigs($values){
		if(!is_array($values) && is_file((string)$values)){
			//#字符串|配置文件路径
			$values=include $values;
		}
		$this->configs=(array)$values;
	}
	/**
	 * 获取所有配置
	 *
	 * @return array
	 */
	public function getConfigs(){
		return $this->configs;
	}
	/**
	 * 添加参数/数组
	 *
	 * @param array $values
	 */
	public function sets(array $values){
		$this->configs=array_merge($this->configs,$values);
	}
	/**
	 * 添加参数
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function set($key,$value){
		$this->configs[$key]=$value;
	}
	/**
	 * 获取参数
	 * 
	 * @param string $key 配置键值
	 * @param string $sub 子项目
	 * @return mixed
	 */
	public function get($key,$sub=''){
		if(!$sub){
			return isset($this->configs[$key])?$this->configs[$key]:null;
		}else{
			return isset($this->configs[$key][$sub])?$this->configs[$key][$sub]:null;
		}
	}
	/**
	 * 获取闭包类型的数据
	 * |懒加载只在使用时，初始化数值，且只初始化一次
	 * |使用使用一些系统常量时使用，APP_PATH
	 *
	 * @param string $key 配置键值
	 * @return mixed
	 */
	public function getClosure($key){
		if(!isset($this->configs[$key])){
			//#不存在
			return null;
		}
		$value=$this->configs[$key];
		if(is_object($value) && $value instanceof \Closure){
			//#从闭包中取得值|替换|只需要初始化一次
			$value=$this->configs[$key]=call_user_func($value);
		}
		return $value;
	}
}	
?>
<?php 
namespace qing\console;
/**
 * 命令行参数包
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ArgumentBag{
	/**
	 * 参数/数字索引
	 * 
	 * @var array
	 */
	protected $arguments=[];
	/**
	 * 选项/字符串索引
	 * 
	 * ## 不带值开关/true或false
	 * --opt
	 * 
	 * ## 带值选项
	 * --opt=aaa
	 * 
	 * @var array
	 */
	protected $options=[];
	/**
	 * @param array $argv
	 */
	public function __construct(array $argv){
		if(!$argv){
			return;
		}
		$idx=1;
		foreach($argv as $arg){
			if($arg[0]=='-'){
				$opt=explode('=',$arg);
				if(isset($opt[1])){
					//指定值
					$value=$opt[1];
				}else{
					//开关值
					$value=true;
				}
				//选项
				$this->options[ltrim($opt[0],'-')]=$value;
			}else{
				//参数，从1开始
				$this->arguments[$idx]=$arg;
				$idx++;
			}
		}
	}
	/**
	 * 
	 * @param string $key
	 * @param string $def
	 * @return string
	 */
	public function argument($key,$def=null){
		if(is_null($key)){
			return $this->arguments;
		}
		return isset($this->arguments[$key])?$this->arguments[$key]:$def;
	}
	/**
	 * @return array
	 */
	public function arguments(){
		return $this->arguments;
	}
	/**
	 *
	 * @param string $key
	 * @param string $def
	 * @return string
	 */
	public function option($key,$def=null){
		if(is_null($key)){
			return $this->options;
		}
		return isset($this->options[$key])?$this->options[$key]:$def;
	}
	/**
	 * @return array
	 */
	public function options(){
		return $this->options;
	}
}
?>
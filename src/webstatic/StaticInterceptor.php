<?php
namespace qing\webstatic;
use qing\interceptor\Interceptor;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class StaticInterceptor extends Interceptor{
	/**
	 * 模块
	 *
	 * @var string
	 */
	public $module=MAIN_MODULE;
	/**
	 * 指定配置文件
	 * 
	 * @var string
	 */
	public $configFile;
	/**
	 * @var string
	 */
	public $debug=false;
	/**
	 * 是否清除注释|是否格式化
	 *
	 * @var string
	 */
	public $format=false;
	/**
	 * 必须使用filelist,不能扫描目录，因为加载顺序不同，可能导致错误，或被覆盖！
	 * 
	 * @see \qing\interceptor\Interceptor::preHandle()
	 */
	public function preHandle(){
		if($this->configFile=='' || !is_file($this->configFile)){
			// /main/static/config.php|/admin/static/config.php
			$path=mod($this->module)->getBasePath().DS.'static';
			$this->configFile=$path.DS.'config.php';
		}
		//
		$confs=(array)require $this->configFile;
		if(!$confs){
			return true;
		}
		//#
		WebStatic::format($confs,$this->debug,$this->format);
		
		return true;
	}
}
?>
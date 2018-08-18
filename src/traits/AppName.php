<?php 
namespace qing\traits;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
trait AppName{
	/**
	 * 应用名称
	 * 
	 * @var string
	 */
	public $appName=MAIN_APP;
	/**
	 *
	 * @param string $appName
	 * @return $this
	 */
	public function appName($appName){
		$this->appName=$appName;
		return $this;
	}
}
?>
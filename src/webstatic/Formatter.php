<?php
namespace qing\webstatic;
use qing\filesystem\MK;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Formatter{
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
	 * @param sreing $listFile
	 * @param sreing $cacheFile
	 * @return boolean
	 */
	public function format($listFile,$cacheFile){
		$files	=Utils::parseFilelist($listFile);
		$content=Utils::mergeFile($files,$this->debug);
		//
		$this->format && $content=$this->formatContent($content);
		//#
		MK::dir(dirname($cacheFile));
		file_put_contents($cacheFile,$content);
	}
	/**
	 * @param string $content
	 * @return string
	 */
	protected function formatContent($content){
		return $content;
	}
}
?>
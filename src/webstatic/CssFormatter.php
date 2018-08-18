<?php
namespace qing\webstatic;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class CssFormatter extends Formatter{
	/**
	 * 获取css文件内容，并格式化
	 *
	 * @param string $content
	 * @return string
	 */
	protected function formatContent($content){
		$pattern=array(
				'/[\n\r\t\f]+/',
				'/ {2,}/',
				'/\/\*.*?\*\//s'
		);
		$replacement=array(
				'',
				' ',
				''
		);
		return preg_replace($pattern,$replacement,$content);
	}	
}
?>
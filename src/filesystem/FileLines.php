<?php
namespace qing\filesystem;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0 all rights reserved.
 */
class FileLines{
	/**
	 * 逐行读取文件
	 *
	 * $content=file_get_content($filename);
	 * $content=explode("\n",$content);
	 *
	 * @param string $filename
	 * @return array
	 */
	public static function filelines($filename){
		if(!is_file($filename)){return [];}
		return explode("\n",file_get_contents($filename));
	}
}
?>
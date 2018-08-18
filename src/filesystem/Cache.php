<?php
namespace qing\filesystem;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Cache{
	/**
	 * 保存内容到文件，包括数组
	 * file_put_contents($file, $content_2,FILE_APPEND)
	 * 
	 * @param $filename 文件名
	 * @param $content 保存内容
	 */
	public static function set($filename,$content){
		if(is_array($content)){
			$content=var_export($content,true);
			$content="<?php\n return {$content};\n?>";
		}
		file_put_contents($filename,$content);
	}
	/**
	 *
	 * @param $filename 文件名
	 */
	public static function get($filename){
		return file_get_contents($filename);
	}
}
?>
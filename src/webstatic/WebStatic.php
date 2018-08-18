<?php
namespace qing\webstatic;
use qing\exceptions\NotfoundFileException;
use qing\exceptions\Required;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class WebStatic{
	/**
	 * @param array $configs
	 * @param boolean $debug
	 * @param boolean $format
	 */
	static public function format(array $confs,$debug=false,$format=true){
		$cssF=new CssFormatter();
		$jsF=new JsFormatter();
		//
		foreach($confs as $conf){
			//#css/js/dirs
			$type =(string)$conf['type'];
			//#filelist文件名
			$files=(string)$conf['files'];
			//#缓存文件名
			$cache=(string)$conf['cache'];
			//
			if(!is_file($files)){
				throw new NotfoundFileException($files);
			}
			if(!$type){
				throw new Required($type);
			}
			$type=strtolower($type);
			if($type=='copy'){
				//复制
				Copy::format($files,$cache);
				return;
			}
			if($type=='js'){
				//js
				$formater=$jsF;
			}else{
				//css
				$formater=$cssF;
			}
			$formater->debug =isset($conf['debug'])?(bool)$conf['debug']:$debug;
			$formater->format=isset($conf['format'])?(bool)$conf['format']:$format;
			$formater->format($files,$cache);
		}
	}
}
?>
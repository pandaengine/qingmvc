<?php
namespace qing\mv;
use qing\response\Xml;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Xml extends Message{
	/**
	 * @param array $datas
	 * @return \qing\response\Xml
	 */
	static public function show(array $datas){
		return new Xml($datas);
	}
}
?>
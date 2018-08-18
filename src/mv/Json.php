<?php
namespace qing\mv;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Json extends Message{
	/**
	 * @param array $datas
	 * @return \qing\response\Json
	 */
	static public function show(array $datas){
		return new \qing\response\Json($datas);
	}
}
?>
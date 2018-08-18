<?php
namespace qing\container;
/**
 * @see psr-11
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface ContainerInterface{
	/**
	 * 从容器中取得一个实例
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function get($id);
	/**
	 * 绑定一个到容器
	 *
	 * @param string $id
	 * @param mixed  $service string/array/clusole
	 * @return true
	 */
	public function set($id,$service);
	/**
	 * 判断是否存在
	 *
	 * @param string $id
	 * @return boolean
	 */
	public function has($id);
}
?>
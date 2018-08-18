<?php
namespace qing\container;
/**
 * 服务定位器
 * 
 * - 单例模式|每次获取的都是同一个实例
 * - 应用主线的服务定位
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface ServiceLocatorInterface{
	/**
	 * 绑定一个到容器
	 *
	 * @param string $id
	 * @param mixed  $service string/array/clusole
	 * @return true
	 */
	public function set($id,$service);
	/**
	 * 从容器中取得一个实例
	 *
	 * @param string $id
	 * @return mixed
	 */
	public function get($id);
	/**
	 * 创建服务
	 *
	 * @param mixed  $service
	 * @param string $id
	 * @return mixed
	 */
	public function create($service,$id='');
	/**
	 * 判断是否存在
	 *
	 * @param string $id
	 * @return boolean
	*/
	public function has($id);
	/**
	 * 移除服务
	 *
	 * @param string  $id 服务ID标识
	 * @param boolean $removeService
	 * @return boolean
	 */
	public function remove($id);
}
?>
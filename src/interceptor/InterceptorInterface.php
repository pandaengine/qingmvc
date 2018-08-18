<?php
namespace qing\interceptor;
/**
 * - 处理器拦截器
 * - 应用级别/请求级别的拦截器
 * - 全局性的拦截器
 * - 类似servlet-filter
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
interface InterceptorInterface{
	/**
	 * 前置处理标识
	 * 
	 * @var string
	 */
	const PRE=-1;
	const POST=1;
	const AFTER=2;
	/**
	 * 预处理,前置处理
	 * 
	 * # 返回false，则该请求将终止
	 * 可以在该方法内显示拒绝的信息，否则页面是空白的
	 * 
	 * # 顾名思义，该方法将在请求处理之前进行调用。
	 * SpringMVC 中的Interceptor 是链式的调用的，在一个应用中或者说是在一个请求中可以同时存在多个Interceptor 。
	 * 每个Interceptor 的调用会依据它的声明顺序依次执行，而且最先执行的都是Interceptor 中的preHandle 方法，
	 * 所以可以在这个方法中进行一些前置初始化操作或者是对当前请求的一个预处理，也可以在这个方法中进行一些判断来决定请求是否要继续进行下去。
	 * 
	 * @return boolean true/false
	 */
	public function preHandle();
	/**
	 * 后处理
	 */
	public function postHandle();
	/**
	 * 完成后处理
	 */
	public function afterCompletion();
}
?>
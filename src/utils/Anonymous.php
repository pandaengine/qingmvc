<?php
namespace qing\utils;
/**
 * 匿名函数
 * 
 * @name closure
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Anonymous{
	/**
	 * 清空闭包的$this对象和类作用域
	 * Closure::bindTo — 复制当前闭包对象，绑定指定的$this对象和类作用域。
	 * “绑定的对象”决定了函数体中的 $this 的取值
	 * “类作用域”代表一个类型、决定在这个匿名函数中能够调用哪些 私有 和 保护 的方法。
	 *
	 * $closure->bindTo(null,null);
	 *
	 * @param newthis 绑定给匿名函数的一个对象，或者 NULL 来取消绑定。
	 * @param newscope 关联到匿名函数的类作用域，或者 'static' 保持当前状态。
	 * 如果是一个对象，则使用这个对象的类型为心得类作用域。
	 * 这会决定绑定的对象的 保护、私有成员 方法的可见性。
	 * @param \Closure $closure
	 */
	public static function bindnull(\Closure $closure){
		$closure=$closure->bindTo(null,'static');
		return $closure;
	}	
}
?>
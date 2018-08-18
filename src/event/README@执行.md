
- 调度到事件监听器链
- 事件处理器分发器

触发一个事件，执行一个事件
这种方法代表一个事件的发生。
---

is_callable(array('A','b')) 					true
call_user_func(array('A','b'),array());
	必须是静态方法，non-static method A::b() should not be called statically
	
call_user_func(array(new A(),'b'),array())

---

改变事件参数对象有两种方式

- 引用原型			`f_test01(&$event){} $event->params['name']='lulu';`
- 返回Event对象
- 闭包中直接更改参数值就能反映到原始变量   `Closure $event->params['name']='lulu';`

---

改变事件内数据
`$event->params['name']='lulu';`
更改传入的Event对象会影响到原始对象，$this，对象依靠引用传播
 
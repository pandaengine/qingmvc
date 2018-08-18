
http://php.net/manual/zh/language.oop5.magic.php

```
__construct(), __destruct(), 
__call(), __callStatic(), __get(), __set(), __isset(), __unset(), 
__sleep(), __wakeup(), __toString(), __invoke(), __set_state() 和 __clone() 

---
重写：子类父类的关系|方法名相同参数相同返回值相同
重载：类内关系|方法名相同参数不同|php不支持可以使用魔术方法__call实现

PHP所提供的"重载"（overloading）是指动态地"创建"类属性和方法。
我们是通过魔术方法（magic methods）来实现的。
当调用当前环境下未定义或不可见的类属性或方法时，重载方法会被调用。

- 所有的重载方法都必须被声明为 public。
- 这些魔术方法的参数都不能通过引用传递。

- 使用 __call() 和 __callStatic() 对方法重载
- 使用 __get()，__set()，__isset() 和 __unset() 进行属性重载

```

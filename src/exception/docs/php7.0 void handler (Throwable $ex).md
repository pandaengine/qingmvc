
#exception_handler
当一个未捕获的异常发生时所调用函数的名称。 
该处理函数需要接受一个参数，该参数是一个抛出的异常对象。 PHP 7 以前的异常处理程序签名：

void handler ( Exception $ex )

```
自 PHP 7 以来，大多数错误抛出 Error 异常，也能被捕获。 
Error 和 Exception 都实现了 Throwable 接口。 
PHP 7 起，处理程序的签名：

void handler ( Throwable $ex )
也可以传递 NULL 值用于重置异常处理函数为默认值。
```

#Caution
注意，**如果在用户回调里将 ex 参数的类型明确约束为Exception， PHP 7 中由于异常类型的变化，将会产生问题。**

#返回值 ¶
返回之前定义的异常处理程序的名称，或者在错误时返回 NULL。 
如果之前没有定义错误处理程序，也会返回 NULL。


#更新日志 ¶
版本	说明
7.0.0	传入 exception_handler 的参数从 Exception 改为 Throwable
5.5.0	之前版本里，如果传入 NULL ，函数会返回 TRUE。 自 PHP 5.5.0 后，会返回上一次的异常处理器。

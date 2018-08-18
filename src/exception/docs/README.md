
- 自 PHP 7 以来，大多数错误抛出 Error 异常，也能被捕获。 
- Error 和 Exception 都实现了 Throwable 接口。 PHP 7 起，处理程序的签名：

#Caution
注意，如果在用户回调里将 ex 参数的类型明确约束为Exception， PHP 7 中由于异常类型的变化，将会产生问题。

---

TODO 2015.12.19
#抛出的异常错误信息|用户可以可以篡改|避免xss

- 控制器操作名等
- 验证器错误信息|字段等


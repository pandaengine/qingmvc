
# 危险字符

- 单双引号 '' ""
- 转义符号 \
- html标签 <>

---

-验证扩展类或静态函数
-复杂的使用扩展类，简单的用静态函数即可
-简单明了的手动调用
-能用系统函数的，直接使用，不需要再新建一个过滤器

-配合row使用，简单调用即可
-静态方法使用f_开头，默认和类名相同，Email::f_email


# 类型

- 数据过滤器
- 数据验证器

- 验证过滤器:Validator
- 净化过滤器:Filter

# 数据来源

- 表单数据
- query_string
- cookie
- 其他用户输入数据

`
/u (PCRE_UTF8)
 此修正符打开一个与 perl 不兼容的附加功能。 
模式和目标字符串都被认为是 utf-8 的。 
`

- slashes: 斜杠
- quotes: 引号
- strip: 剥离


# htmlspecialchars html special chars
	html special chars 转义html特殊字符成实体
	Convert special characters to HTML entities
	
	把一些预定义的字符转换为 HTML 实体。
	-----------------------
	预定义的字符是：
	& （和号） 成为 &amp;
	" （双引号） 成为 &quot;
	' （单引号） 成为 &#039;
	< （小于） 成为 &lt;
	> （大于） 成为 &gt;
	-------------------------
	ENT_COMPAT - 默认/仅编码双引号
	ENT_QUOTES - 编码双引号和单引号
	ENT_NOQUOTES - 不编码任何引号
	
# htmlentities
	html entities | entities实体 
	Convert all applicable characters to HTML entities | 将所有适用的字符为HTML实体 
	


# 剥离php/html标签
# 单双引号等转换为实体|\转义符号没有转换!|避免输出引号<>等影响html展示混乱/变相XSS

<a href="<>"'\"></a>


-----

XSS==CSS==Cross Site Script==跨站脚本攻击。

# 它指的是恶意攻击者往Web页面里插入恶意html代码，
# 当用户浏览该页之时，嵌入其中Web里面的html代码会被执行，从而达到恶意用户的特殊目的。
# 【窃取用户cookie,会话ID,Session id,会话重放】

------------------------------------------------------------

攻击方式：

## html标签插入恶意脚本：
<img src='javascript:alert("XSS");' />
<a href='javascript:alert("XSS");   '></a>
<tag onerror omouseover onload='alert("XSS");'></tag>


## cookie插入恶意脚本： 不经过滤的cookie值显示在页面的时候就造成攻击

------------------------------------------------------------

预防措施：

## URL方面：

不要直接输出：
QUERY_STRING、REQUEST_URI自动编码了，安全
PATH_INFO、PHP_SELF自动解码url，不安全
 
$_SERVER['REQUEST_URI']编码，相对安全；（/index.php/Post/index?id=320&b=%3Cb%3EHOHO%3C/b%3E，pathinfo和querystring）、
$_SERVER['PHP_SELF']不安全！（/index.php/Post/index，pathinfo部分）、等等，

用户只要请求恶意链接就造成xss攻击
$_SERVER['SCRIPT_NAME']是安全的(/index.php)

?from=http://qingmvc.xyz/passport.php/<b>123</b>

##不要直接输出用户可以控制的内容，URL



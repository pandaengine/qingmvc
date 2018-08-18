
会话劫持，session安全

- 可以xss通过获得cookie信息，包含sessionid【会话劫持】
- 可以通过截取http，获得header信息，包含sessionid【会话劫持】

以上两种法都有一定条件和难度
- 如果服务端单靠sessionid识别会话信息，那么通过xss获取了sessionid后，会泄露用户信息，如果再通过ip，useragent信息加以校验，可以减少风险
- 如果截取了http，换用https方式可以减少风险
- 即便是使用https，ssl证书也是可以伪造

结论：
- xss漏洞更低级一些，但是造成的风险很大。
- http截取，截取范围很小，风险小。当然，截取到admin的信息，那就不一样了。
- http截取/ssl证书伪造的技术要求、环境要求较高，防治的成本也大。

#---------------------------------------------------------------

- 把IE浏览器的PHPSESSID cookie获取
- 修改到chrome浏览器的cookie|uc1d78qtp2fu27asl491olbiq0
- 会劫持了用户会话

# 打印cookie信息：document.cookie | PHPSESSID=t9vt2bo839g9hpq1lkhnuqfiu6
# 修改cookie信息：document.cookie='PHPSESSID=t9vt2bo839g9hpq1lkhnuqfiu6'


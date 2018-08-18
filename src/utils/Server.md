
# 'SERVER_ADDR'
	
当前运行脚本所在的服务器的 IP 地址。

# 'SERVER_NAME'
当前运行脚本所在的服务器的主机名。如果脚本运行于虚拟主机中，该名称是由那个虚拟主机所设置的值决定。


## Note: 

在 Apache 2 里，必须设置 UseCanonicalName = On 和 ServerName。 
否则该值会由客户端提供，就有可能被伪造。 
上下文有安全性要求的环境里，不应该依赖此值。

# 'SERVER_SOFTWARE'

服务器标识字符串，在响应请求时的头信息中给出。

# 'SERVER_PROTOCOL'

请求页面时通信协议的名称和版本。例如，“HTTP/1.0”。

# 客户端 ip

## 'REMOTE_ADDR'

浏览当前页面的用户的 IP 地址。



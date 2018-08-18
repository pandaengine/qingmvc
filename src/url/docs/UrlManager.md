
- UrlManager和Router是相对应的
- 配置url管理器要设置对应响应的路由解析器，否则路由无法解析

`
get : index.php?m=member&c=Index&a=login
path: index.php/.member/index/login
rpath: index.php?r=/.member/index/login
`


__HOME__: 不会为空，首页，但不能用于组织url，__HOME__.'/add'='//add'
__ROOT__: 可能为空，__ROOT__.'/add'='/add'

	 
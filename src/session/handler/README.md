
Cache
Db
File
Mysql
Redis

```
$handler = new MySessionHandler();
session_set_save_handler($handler, true);
session_start();
```

# 一些 PHP 扩展也提供了内置的会话管理器

例如：sqlite， memcache 以及 memcached， 可以通过配置项 session.save_handler 来使用它们。


# SessionHandlerInterface SessionHandler

会话数据的序列化和逆序列化都是自动完成的


`
implements \SessionHandlerInterface,\SessionIdInterface{}
/**
 * 创建sessionid
 * 
 * @see SessionIdInterface :: create_sid
 */
public function create_sid(){return (string)time();}	
`
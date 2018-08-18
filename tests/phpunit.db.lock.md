
# 锁相关

- 有部分死锁，耗时较长

```
phpunit -c phpunit.db.lock.xml
```

# 单个用例

```
//lock
phpunit --bootstrap ./autoload.php ./db/lock/Timeout01Test.php
phpunit --bootstrap ./autoload.php ./db/lock/ForUpdateTest.php
phpunit --bootstrap ./autoload.php ./db/lock/ShareModeTest.php

phpunit --bootstrap ./autoload.php ./db/lock/TableLockTest.php

//myisam
phpunit --bootstrap ./autoload.php ./db/lock/MyISamTest.php
phpunit --bootstrap ./autoload.php ./db/lock/ModelLockTest.php

```

## lock tables read/write

```
phpunit -c phpunit.db.lock.LockTablesMyIsamTest.xml

//lock tables
phpunit --bootstrap ./autoload.php ./db/lock/LockTablesTest.php
phpunit --bootstrap ./autoload.php ./db/lock/LockTablesMyIsamTest.php

//开启一个命令行
phpunit --bootstrap ./autoload.php ./db/lock/LockTablesMyIsamTest.php --filter ::testRead$

//开启另一个命令行，使用不同的进程才能进行该测试
phpunit --bootstrap ./autoload.php ./db/lock/LockTablesMyIsamTest.php --filter ::testReadConn2

//控制台1
phpunit --bootstrap ./autoload.php ./db/lock/LockTablesMyIsamWriteTest.php --filter ::test$
//控制台2
phpunit --bootstrap ./autoload.php ./db/lock/LockTablesMyIsamWriteTest.php --filter ::testConn2$
//控制台3
phpunit --bootstrap ./autoload.php ./db/lock/LockTablesMyIsamWriteTest.php --filter ::testConn3$

```
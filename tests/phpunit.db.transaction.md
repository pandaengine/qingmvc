
# 事务相关

- 有部分死锁，耗时较长

```
phpunit -c phpunit.db.transaction.xml
```


```
//事务
phpunit --bootstrap ./autoload.php ./db/transaction/Trans01Test.php
phpunit --bootstrap ./autoload.php ./db/transaction/Trans02Test.php

//事务隔离
phpunit --bootstrap ./autoload.php ./db/transaction/DirtyReadTest.php
//串行化时，发生死锁，耗时较长
phpunit --bootstrap ./autoload.php ./db/transaction/NonRepeatableReadTest.php

phpunit --bootstrap ./autoload.php ./db/transaction/PhantomReadTest.php
phpunit --bootstrap ./autoload.php ./db/transaction/LostUpdateTest.php

//myisam
phpunit --bootstrap ./autoload.php ./db/transaction/MyISamTest.php

```

```
//
phpunit --bootstrap ./autoload.php ./db/TransactionTest.php
phpunit --bootstrap ./autoload.php ./db/TransactionIsolationTest.php
```
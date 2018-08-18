
# 执行数据库相关测试用例

- 涉及到数据库操作
- 测试需要的时间可能稍长

```
phpunit -c phpunit.db.xml
```

```
phpunit --bootstrap ./autoload.php ./db

//where
phpunit --bootstrap ./autoload.php ./db/WhereTest.php
phpunit --bootstrap ./autoload.php ./db/Where02Test.php
phpunit --bootstrap ./autoload.php ./db/Where03Test.php

phpunit --bootstrap ./autoload.php ./db/SqlBuilderTest.php
phpunit --bootstrap ./autoload.php ./db/ConnectionTest.php
phpunit --bootstrap ./autoload.php ./db/ModelTest.php

//
phpunit --bootstrap ./autoload.php ./db/ProcessTest.php
phpunit --bootstrap ./autoload.php ./db/ModelSelectTest.php


```
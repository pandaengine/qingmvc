
# 执行整个测试套件

- 排除了一些目录db/smarty

```
phpunit --bootstrap ./autoload.php ./
phpunit -c phpunit.xml
```

# 执行整个测试套件,包括目录db


# 需要配置第三方库的用例

## smarty

```

phpunit --bootstrap ./autoload.php ./views/smarty/SmartyTest.php
phpunit -c phpunit.smarty.xml

```

# 执行单个用例

```
# phpunit ./
# phpunit -c phpunit.xml ./
# phpunit -c phpunit.testing.xml
# phpunit -c ./phpunit.testing.xml

phpunit ./db/WhereTest.php
phpunit ./TemplateMethodsTest.php

phpunit --bootstrap ./autoload.php ./app/AppTest.php


//com
phpunit --bootstrap ./autoload.php ./com/Com01Test.php

//container
phpunit --bootstrap ./autoload.php ./container/Con01Test.php

//router
phpunit --bootstrap ./autoload.php ./router/PathinfoTest.php
phpunit --bootstrap ./autoload.php ./router/GetTest.php
phpunit --bootstrap ./autoload.php ./router/AliasTest.php
phpunit --bootstrap ./autoload.php ./router/RoutersTest.php

//url
phpunit --bootstrap ./autoload.php ./url/UrlManager01Test.php
phpunit --bootstrap ./autoload.php ./url/UrlManager02Test.php

//event
phpunit --bootstrap ./autoload.php ./event/Event01Test.php
phpunit --bootstrap ./autoload.php ./event/Event02Test.php

//views

```

`
file_put_contents(__DIR__.'/~log.md','',FILE_APPEND);
`

# 执行目录下的所有用例

```
phpunit --bootstrap ./autoload.php ./validator
phpunit --bootstrap ./autoload.php ./url

```


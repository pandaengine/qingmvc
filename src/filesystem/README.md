
# QingMVC 文件系统工具类

qingmvc filesystem utils

- http://qingmvc.com
- http://qingcms.com
- http://logo234.com  
- http://mangdian.net  

# 案例

```
<?php
use qing\filesystem\Path;
use qing\filesystem\MK;
use qing\filesystem\FileSize;

MK::dir('/data/dir01');

dump(FileSize::format(234));
dump(FileSize::format(150*1024));
dump(FileSize::format(15000*1024*1024));
exit();

dump(FileSize::format(1500*1024,'B'));
dump(FileSize::format(1500*1024,'KB'));
dump(FileSize::format(1500*1024,'mb'));
dump(FileSize::format(1500*1024,'Gb'));
exit();

dump(Path::formatDS('X:\qingmvc\src\filesystem','/'));
dump(Path::formatDS('X:\qingmvc\src\filesystem\我是\哈哈','/'));

//---

$path='X:\qingmvc\src\filesystem\我是\哈哈';
$rootpath='X:\qingmvc\src';

dump(Path::formatDS($path,'/'));

dump(dirname($path));
dump(Path::dirname($path));

dump(basename($path));
dump(Path::basename($path));

dump(Path::relativePath($path,$rootpath));
exit();
?>
```

<?php
use qing\filesystem\Path;

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
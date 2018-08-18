flock

(PHP 4, PHP 5, PHP 7)
flock — 轻便的咨询文件锁定

说明

bool flock ( resource $handle , int $operation [, int &$wouldblock ] )

flock() 允许执行一个简单的可以在任何平台中使用的读取/写入模型（包括大部分的 Unix 派生版和甚至是 Windows）。

在 PHP 5.3.2版本之前，锁也会被 fclose() 释放（在脚本结束后会自动调用）。

PHP 支持以咨询方式（也就是说所有访问程序必须使用同一方式锁定, 否则它不会工作）锁定全部文件的一种轻便方法。 默认情况下，这个函数会阻塞到获取锁；这可以通过下面文档中 LOCK_NB 选项来控制（在非 Windows 平台上）。

参数

handle
文件系统指针，是典型地由 fopen() 创建的 resource(资源)。

operation
operation 可以是以下值之一：

LOCK_SH取得共享锁定（读取的程序）。
LOCK_EX 取得独占锁定（写入的程序。
LOCK_UN 释放锁定（无论共享或独占）。
如果不希望 flock() 在锁定时堵塞，则是 LOCK_NB（Windows 上还不支持）。

wouldblock
如果锁定会堵塞的话（EWOULDBLOCK 错误码情况下），可选的第三个参数会被设置为 TRUE。（Windows 上不支持）

返回值

成功时返回 TRUE， 或者在失败时返回 FALSE。

更新日志

版本	说明
5.3.2	在文件资源句柄关闭时不再自动解锁。现在要解锁必须手动进行。
4.0.1	增加了常量 LOCK_XXX。 之前你必须使用 1 代表 LOCK_SH，2 代表 LOCK_EX，3 代表LOCK_UN，4 代表 LOCK_NB。
范例

Example #1 flock() 例子

<?php

$fp = fopen("/tmp/lock.txt", "r+");

if (flock($fp, LOCK_EX)) {  // 进行排它型锁定
    ftruncate($fp, 0);      // truncate file
    fwrite($fp, "Write something here\n");
    fflush($fp);            // flush output before releasing the lock
    flock($fp, LOCK_UN);    // 释放锁定
} else {
    echo "Couldn't get the lock!";
}

fclose($fp);

?>
Example #2 flock() 使用 LOCK_NB 选项

<?php
$fp = fopen('/tmp/lock.txt', 'r+');

/* Activate the LOCK_NB option on an LOCK_EX operation */
if(!flock($fp, LOCK_EX | LOCK_NB)) {
    echo 'Unable to obtain lock';
    exit(-1);
}

/* ... */

fclose($fp);
?>
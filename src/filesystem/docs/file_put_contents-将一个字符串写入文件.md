

file_put_contents($filename,$content,FILE_APPEND | LOCK_EX)
---

file_put_contents — 将一个字符串写入文件

# 说明

`
int file_put_contents ( string $filename , mixed $data [, int $flags = 0 [, resource $context ]] )
`

和依次调用 fopen()，fwrite() 以及 fclose() 功能一样。

If filename does not exist, the file is created. Otherwise, 
the existing file is overwritten, unless the FILE_APPEND flag is set.

# 参数

-  filename
	要被写入数据的文件名。

- data
	要写入的数据。类型可以是 string，array 或者是 stream 资源（如上面所说的那样）。

	如果 data 指定为 stream 资源，这里 stream 中所保存的缓存数据将被写入到指定文件中，
		这种用法就相似于使用 stream_copy_to_stream() 函数。

	参数 data 可以是数组（但不能为多维数组），这就相当于 file_put_contents($filename, join('', $array))。

- flags
	flags 的值可以是 以下 flag 使用 OR (|) 运算符进行的组合。
	`FILE_APPEND | LOCK_EX`
	
> Available flags

Flag					|描述
------------------------|---------------------
FILE_USE_INCLUDE_PATH	|在 include 目录里搜索 filename。 更多信息可参见 include_path。
FILE_APPEND				|如果文件 filename 已经存在，追加数据而不是覆盖。
LOCK_EX					|在写入时**获得一个独占锁**。

- context
	一个 context 资源。

返回值

该函数将返回写入到文件内数据的字节数，失败时返回FALSE

Warning
此函数可能返回布尔值 FALSE，但也可能返回等同于 FALSE 的非布尔值。请阅读 布尔类型章节以获取更多信息。应使用 === 运算符来测试此函数的返回值。
范例

Example #1 Simple usage example

<?php
$file = 'people.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= "John Smith\n";
// Write the contents back to the file
file_put_contents($file, $current);
?>
Example #2 Using flags

<?php
$file = 'people.txt';
// The new person to add to the file
$person = "John Smith\n";
// Write the contents to the file, 
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
?>
更新日志

版本	说明
5.0.0	Added context support
5.1.0	添加了对 LOCK_EX 的支持和 data 参数处理 stream 资源的功能。
注释

Note: 此函数可安全用于二进制对象。
Tip
如已启用fopen 包装器，在此函数中， URL 可作为文件名。关于如何指定文件名详见 fopen()。各种 wapper 的不同功能请参见 支持的协议和封装协议，注意其用法及其可提供的预定义变量。
参见

fopen() - 打开文件或者 URL
fwrite() - 写入文件（可安全用于二进制文件）
file_get_contents() - 将整个文件读入一个字符串
stream_context_create() - 创建资源流上下文

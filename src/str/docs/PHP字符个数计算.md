#PHP 字符个数计算
有时比如注册用户，需要检查用户名的长度，可能会用到以下两个函数来做判断

strlen
int strlen ( string $string )     返回给定的字符串 string 的长度。

注意：它返回的是字符串字节的个数，并非字符的个数，假设一个汉字“你”可能会返回3，具体看你用的什么编码

 

mb_strlen
int mb_strlen ( string $str [, string $encoding ] )  返回字符串字符的个数。

str
具体字符串

encoding
encoding 参数为字符编码。如果省略，则使用内部字符编码。

注意：一定要开启php.ini 文件中的php_mbstring.dll

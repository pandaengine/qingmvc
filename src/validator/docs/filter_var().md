PHP filter_var() 函数
PHP  函数
#定义和用法
filter_var() 函数通过指定的过滤器过滤变量。
如果成功，则返回已过滤的数据，如果失败，则返回 false。
#语法
filter_var(variable, filter, options)
#参数	描述
variable	必需。规定要过滤的变量。
filter	可选。规定要使用的过滤器的 ID。
options	规定包含标志/选项的数组。检查每个过滤器可能的标志和选项。
#提示和注释
提示：参见完整的 PHP  参考手册，查看可与该函数一同使用的过滤器。
#例子
<?php
if(!filter_var("someone@example....com", FILTER_VALIDATE_EMAIL))
 {
 echo("E-mail is not valid");
 }
else
 {
 echo("E-mail is valid");
 }
?>
输出类似：
E-mail is not valid
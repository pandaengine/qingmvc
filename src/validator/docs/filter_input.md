filter_input

(PHP 5 >= 5.2.0, PHP 7)

filter_input — 通过名称获取特定的外部变量，并且可以通过过滤器处理它

# 说明

mixed filter_input ( int $type , string $variable_name [, int $filter = FILTER_DEFAULT [, mixed $options ]] )

# 参数

1. type

INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER或 INPUT_ENV之一。

2. variable_name
待获取的变量名。

3. filter

The ID of the filter to apply. The Types of filters manual page lists the available filters.

If omitted, FILTER_DEFAULT will be used, which is equivalent to FILTER_UNSAFE_RAW. This will result in no filtering taking place by default.

4. options

一个选项的关联数组，或者按位区分的标示。如果过滤器接受选项，可以通过数组的 "flags" 位去提供这些标示。

# 返回值

如果成功的话返回所请求的变量。
如果过滤失败则返回 FALSE ，如果variable_name 不存在的话则返回 NULL 。 
如果标示 FILTER_NULL_ON_FAILURE 被使用了，那么当变量不存在时返回 FALSE ，当过滤失败时返回 NULL 。

# 范例

## Example #1 一个 filter_input() 的例子

```
<?php
$search_html = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
$search_url = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_ENCODED);
echo "You have searched for $search_html.\n";
echo "<a href='?search=$search_url'>Search again.</a>";
?>
以上例程的输出类似于：

You have searched for Me &#38; son.
<a href='?search=Me%20%26%20son'>Search again.</a>
```

# 参见

filter_var() - 使用特定的过滤器过滤一个变量
filter_input_array() - 获取一系列外部变量，并且可以通过过滤器处理它们
filter_var_array() - 获取多个变量并且过滤它们
Types of filters
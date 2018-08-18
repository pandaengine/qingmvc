filter_var

(PHP 5 >= 5.2.0, PHP 7)

filter_var — 使用特定的过滤器过滤一个变量

# 说明

mixed filter_var ( mixed $variable [, int $filter = FILTER_DEFAULT [, mixed $options ]] )

# 参数

1. variable

待过滤的变量。注意：标量的值在过滤前，会被转换成字符串。

2. filter

The ID of the filter to apply. The Types of filters manual page lists the available filters.

If omitted, FILTER_DEFAULT will be used, which is equivalent to FILTER_UNSAFE_RAW. This will result in no filtering taking place by default.

3. options

一个选项的关联数组，或者按位区分的标示。
如果过滤器接受选项，可以通过数组的 "flags" 位去提供这些标示。 
对于回调型的过滤器，应该传入 callable。
这个回调函数必须接受一个参数，即待过滤的值，并且 返回一个在过滤/净化后的值。

```
<?php
// for filters that accept options, use this format
$options = array(
    'options' => array(
        'default' => 3, // value to return if the filter fails
        // other options here
        'min_range' => 0
    ),
    'flags' => FILTER_FLAG_ALLOW_OCTAL,
);
$var = filter_var('0755', FILTER_VALIDATE_INT, $options);

// for filter that only accept flags, you can pass them directly
$var = filter_var('oops', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

// for filter that only accept flags, you can also pass as an array
$var = filter_var('oops', FILTER_VALIDATE_BOOLEAN,
                  array('flags' => FILTER_NULL_ON_FAILURE));

// callback validate filter
function foo($value)
{
    // Expected format: Surname, GivenNames
    if (strpos($value, ", ") === false) return false;
    list($surname, $givennames) = explode(", ", $value, 2);
    $empty = (empty($surname) || empty($givennames));
    $notstrings = (!is_string($surname) || !is_string($givennames));
    if ($empty || $notstrings) {
        return false;
    } else {
        return $value;
    }
}
$var = filter_var('Doe, Jane Sue', FILTER_CALLBACK, array('options' => 'foo'));
?>
```

# 返回值

Returns the filtered data, or FALSE if the filter fails.

# 范例

## Example #1 一个 filter_var() 的例子

`
<?php
var_dump(filter_var('bob@example.com', FILTER_VALIDATE_EMAIL));
var_dump(filter_var('http://example.com', FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED));
?>
以上例程会输出：

string(15) "bob@example.com"
bool(false)
```

# 参见

filter_var_array() - 获取多个变量并且过滤它们
filter_input() - 通过名称获取特定的外部变量，并且可以通过过滤器处理它
filter_input_array() - 获取一系列外部变量，并且可以通过过滤器处理它们
Types of filters
callback 类型的信息

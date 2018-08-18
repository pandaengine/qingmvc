<?php 
namespace qing\utils;
/**
 *
 * @param string $mode
 *       'a':  返回所有信息
 *       's':  操作系统的名称，如FreeBSD
 *       'n':  主机的名称,如cnscn.org
 *       'r':  版本名，如5.1.2-RELEASE
 *       'v':  操作系统的版本号
 *       'm': 核心类型，如i386
 * @return string
 *
 * string php_uname([string $mode]);
 dump(PHP_OS);
 dump(php_uname('s'));
 dump(php_uname());
 dump(PATH_SEPARATOR);
 *
 */
function php_uname ($mode = null) {}

/**
 * 默认情况下，
 *  -1 : 在第一个版本低于第二个时,返回 -1
 *  0  : 如果两者相等，返回 0；
 *  1  : 第二个版本更低时则返回 1。
 *
 * 当使用了可选参数 operator 时，如果关系是操作符所指定的那个，函数将返回 TRUE，否则返回 FALSE。
 *
 * version_compare(PHP_VERSION, '7.0.0') >= 0
 * version_compare(PHP_VERSION, '7.0.0', '>=')
 * version_compare(PHP_VERSION, '7.0.0', '<')
 *
 * - phpversion() - 获取当前的PHP版本
 * - php_uname() - 返回运行 PHP 的系统的有关信息
 *
 * @param string $v1
 * @param string $v2
 * @param string $operator
 */
function version_compare ($version1, $version2, $operator = null) {}

?>
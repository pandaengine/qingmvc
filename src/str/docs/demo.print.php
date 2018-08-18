<?php 
namespace qing\str;
/**
 * 字符串格式化输出
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2014 http://qingmvc.com
 */

/**
 * - 绑定sql中的变量,并返回绑定后结果
 * - $this->_bindSql('SELECT * FROM %s %s ORDER BY id DESC %s',$table,$where,$limit);
 * -
 * - $sql=isprintf('SELECT * FROM %s %s ORDER BY id DESC %s','111','222','333','444');
 * - $sql=ivsprintf('SELECT * FROM %s %s ORDER BY id DESC %s',['111','222','333','444']);
 * -------------------------------------------------------------------------------------
 *	%% - 返回百分比符号
 *	%b - 二进制数
 *	%c - 依照 ASCII 值的字符
 *	%d - 带符号十进制数
 *	%e - 可续计数法（比如 1.5e+3）
 *	%u - 无符号十进制数
 *	%f - 浮点数(local settings aware)
 *	%F - 浮点数(not local settings aware)
 *	%o - 八进制数
 *	%s - 字符串
 *	%x - 十六进制数（小写字母）
 *	%X - 十六进制数（大写字母）
 * -------------------------------------------------------------------------------------
 * @param string $str 需要绑定变量参数的sql语句
 * @return string
 */
function sprintf($str){
	$params=func_get_args();
	return call_user_func_array('sprintf',$params);
}
/**
 * 字符串格式化
 *
 * 2.常见用法
 * %d - 带符号十进制数|decimal
 * %u - 无符号十进制数|unsign decimal
 * %s - 字符串|string
 * %b - 二进制|binary
 *
 * vsprintf() 函数把格式化字符串写入变量中。
 * 与 sprintf() 不同，vsprintf() 中的 arg 参数位于数组中。
 * 数组的元素会被插入主字符串的百分比 (%) 符号处。该函数是逐步执行的。
 * 在第一个 % 符号中，插入 arg1，在第二个 % 符号处，插入 arg2，依此类推。
 * -----------------------------------------------------------------------------
 * 过滤%s字符串对应的数据
 *
 * @param string $str 需要格式化字符的sql语句
 * @param array  $params (array)每个占位符对应的数据
 */
function vsprintf($str,array $params=[]){
	return vsprintf($str,$params);
}
/**
 * - 只是替换占位符|language replace
 *
 * + $trans = array("hello" => "hi", "hi" => "hello");
 * + echo strtr("hi all, I said hello", $trans);
 * + hello all, I said hi
 *
 * @see strtr
 * @see str_replace('',[b1,b2],[a1,b1])
 * @name vreplace
 * @param string $str   要替换的字符串|hello world
 * @param array  $maps  [hello=>hi]
 * @return string
 */
function replace($str,array $maps=array()){
	return strtr($str,$maps);
}
/*
function replaceX2($str,array $maps=array()){
	$patterns   =array_keys($maps);
	$replacement=array_values($maps);
	return str_replace($patterns,$replacement,$str);
}
*/
/**
 * 字符串中插入字符
 * #0 - 插入而非替换
 *
 * @param string $string
 * @param string $value
 * @param number $index
 */
function insert($string,$value,$index){
	return substr_replace($string,$value,(int)$index,0);
}
?>

返回字符串，该字符串为了数据库查询语句等的需要在某些字符前加上了反斜线。
这些字符是
- 单引号（'）
- 双引号（"）
- 反斜线（\）与
- NUL（NULL 字符）。

---

安全sql语句|SQL组装字符串，安全过滤|escapeSql/safeSql

----------------------------------------------------
- 特殊符号转义| ' " \ _%

- 转义字符必须转义| 奇数个转义符号必须转义 | \
- 引号必须转义| ' "
- like通配符转义(like查询时才需要转义)| _ % 
- 避免双重转义|避免转义失效| \' | \\'

----------------------------------------------------

$charlist='\\\'"';
if($like){
	$charlist.='_%';
}

-----------------------------------------------------------
'_' 单个字符通配符
'%' 多个字符通配符
addcslashes($value,'_%');
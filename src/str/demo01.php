<?php 

//测试时文件的编码方式要是UTF8
$str='中文a字1符'; 
echo strlen($str).'<br>';//14
echo mb_strlen($str,'utf8').'<br>';//6
echo mb_strlen($str,'gbk').'<br>';//8
echo mb_strlen($str,'gb2312').'<br>';//10

$str = "一1二2三3四4五5六6七7八8九9十0";

//截取字符串，全角半角都占设置长度的一位；支持中文，不会有乱码
echo mb_substr($str, 0, 1, 'utf-8')."\n";
echo mb_substr($str, 0, 2, 'utf-8')."\n";
echo mb_substr($str, 0, 3, 'utf-8')."\n";
//
echo substr($str,0,1)."\n"; // *
echo substr($str,0,2)."\n"; // **
echo substr($str,0,3)."\n"; // 一
echo substr($str,0,4)."\n"; // 一1

?>
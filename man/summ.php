<?php
//大纲生成器
//php -f summ.php

$dirname=__DIR__;
$summary="# Summary\n\n";
foreach(scandir($dirname) as $k=>$file){
	//#是目录/不符合文件名规则
	if(in_array($file,['.','..'])){
		continue;
	}
	$realfile=$dirname.'/'.$file;
	if(is_file($realfile)){
		if(!preg_match('/\.md$/i',$file)){
			//#过滤文件名|跳过文件
			continue;
		}
		$title=rtrim($file,'.md');
		$summary.="* [{$title}]({$file})\n";
	}
}

file_put_contents('SUMMARY.md',$summary);

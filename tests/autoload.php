<?php
use qing\autoload\AutoLoad;
use qing\app\WebApp;
/**
 * 加载qingmvc类自动加载器
 * 如果没有配置composer则可以使用该加载器
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */

function dump($var=''){
	echo "\n[1]------------------------\n";
	var_dump($var);
	echo "\n[2]------------------------\n";
}
function export($var,$filename){
	file_put_contents($filename,var_export($var,true));
}
function qexport($var,$filename){
	file_put_contents($filename,var_export($var,true));
}
//一些配置
require_once __DIR__.'/config.php';
//框架自动加载/或使用composer
require_once __DIR__.'/../autoload.php';

//初始化测试应用./app
//应用配置文件
$configFile=__DIR__.'/_app/config/main.php';
//只初始化应用，不解析http执行
new WebApp($configFile);

//添加命名空间自动加载
AutoLoad::addNamespace('qtests',__DIR__);
?>
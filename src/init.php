<?php
use qing\exception\ExceptionAndError;
/**
 * 初始化框架
 * 框架必须的设置常量
 * 用户可自定义的常量
 * 
 * 约定:
 * APP_ 应用相关
 * QING_ 框架相关
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
//declare(strict_types=1);//类型严格约束
//header("Content-type: text/html; charset=utf-8");

//目录分隔符
defined('DS') 		or define("DS",DIRECTORY_SEPARATOR);
//#创建文件夹/文件的权限/目录必须要有x执行权限，否则php无法写入文件？
defined('MOD_DIR')	or define('MOD_DIR'	,0755);
defined('MOD_FILE')	or define('MOD_FILE',0644);

//设置系统安全常量，不可去除
define('APP_QING'		,true);
//请求脚本目录/程序根目录/wwwroot/realpath('.')
define('APP_SCRIPT'		,$_SERVER['SCRIPT_FILENAME']);
define('APP_PUBLIC'		,dirname(APP_SCRIPT));

//框架所在目录/框架入口文件start.php文件所在路径
define('QING_PATH'		,__DIR__);
//框架目录常量
define('QING_FUNCTION'	,QING_PATH.DS.'_function');
define('QING_CONFIG'	,QING_PATH.DS.'_config');

//
define('KEY_DEFAULT','default');
define('KEY_MAIN'	,'main');

//#自动模块
define('AUTO_MODULE','');
define('MAIN_MODULE','main');//#主模块

//#返回的视图为空|不解析视图|如果字符串''还是会解析的
define('MV_NULL'	,null);
//#返回的视图为空
define('MV_FALSE'	,false);

//debug
defined('APP_DEBUG')   or define('APP_DEBUG' ,false);
//启用日志
defined('LOG_ON')     or define('LOG_ON'	,false);
//事件
defined('EVENT_ON')   or define('EVENT_ON'	,true);

//#extension扩展名
defined('PHP_EXT') 	or define('PHP_EXT'	,'.php');
defined('HTML_EXT') or define('HTML_EXT','.html');
defined('LOG_EXT')  or define('LOG_EXT'	,'.log');

//#视图|使用常量/减少对组件的调用依赖
//视图文件后缀
defined('VIEW_SUFFIX')   	 or define('VIEW_SUFFIX'		,'.html');

//#应用各部分目录|dir key
defined('DKEY_COMMON') 	 or define('DKEY_COMMON'	,'common');
defined('DKEY_CTRL')  	 or define('DKEY_CTRL'		,'controller');
defined('DKEY_VIEWS')  	 or define('DKEY_VIEWS'		,'views');
defined('DKEY_RUNTIME')  or define('DKEY_RUNTIME'	,'~runtime');

//#路由全局设置
//路由键值标识别名/route key
defined('RKEY_MODULE')  	or define('RKEY_MODULE'			,'m');
defined('RKEY_CTRL')    	or define('RKEY_CTRL'			,'c');
defined('RKEY_ACTION')  	or define('RKEY_ACTION'			,'a');
//#路由模块分隔符
defined('R_MODSIGN')  		or define('R_MODSIGN'			,'.');
defined('R_DELIMITER')   	or define('R_DELIMITER'			,'/');
//默认路由
defined('DEF_MODULE')  		or define('DEF_MODULE'			,MAIN_MODULE);
defined('DEF_CTRL')    		or define('DEF_CTRL'			,'index');
defined('DEF_ACTION')  		or define('DEF_ACTION'			,'index');

//类别名
class Qing extends \qing\Qing{}

//立即捕获异常，避免异常输出
//#初始化异常错误捕获组件/在这之前抛出的异常都会被默认程序处理
ExceptionAndError::register();
?>
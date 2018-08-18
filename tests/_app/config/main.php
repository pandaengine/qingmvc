<?php
/**
 * 应用配置
 * 完整版
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
//
return
[
	//模块基础路径
	'basePath'	 =>__DIR__.'/..',
	//时区
	'timezone'	 =>'PRC',
	//应用命名空间
	'namespace'  =>'\main',
	//命名空间映射
	'namespaces' =>
	[
		//'qtemplate'=>'X:\wuati\qingmvc2018\qtemplate\src'
	],
	//类别名
	'aliases'=>
	[
		'Config'	=>'\qing\facades\Config',
		'Event'		=>'\qing\facades\Event',
		'Json'		=>'\qing\facades\Json',
		'Log'		=>'\qing\facades\Log',
		'MV'		=>'\qing\facades\MV',
		'Request'	=>'\qing\facades\Request',
		'Db'		=>'\qing\db\Db',
		'L'			=>'\qing\lang\L',
	],
	//设置可侦测环境|只有在主配置有效
	'environments'=>
	[
		'local' =>['hostname','tp-xiaowang']
	],
	//模块
	'modules'	=>['main'=>['class'=>'\main\MainModule']],
	//拦截器
	'interceptors'=>
	[
		
	],
	//组件列表
	'components'=>
	[
		//默认数据库连接
		'db@main'=>include __DIR__.'/main.db.php',
		//第二连接，测试事务隔离
		'db@conn2'=>include __DIR__.'/main.db.php',
		//视图组件
		'view'=>
		[
			'class'=>'\qing\view\CachedView'
		],
		//视图编译组件
		'view.compiler'=>
		[
			'creator'=>'\qtemplate\CompilerCreator',
		],
		//容器，分类实例
		'container'=>
		[
			'cats'=>['M'=>'\main\model\%s','C'=>'\main\controller\%s']
		],
		//自定义组件
		//demo01组件
		'demo01'=>
		[
			'class'		=>'\main\coms\Demo01',//指定组件类
			'name'		=>'xiaowang',//属性1
			'nickname'	=>'dawang'//属性2
		],
		//demo0101组件
		'demo0101'=>
		[
			'creator'	=>'\main\coms\Demo01Creator',//指定组件创建器
			'name'		=>'qingmvc',//属性，优先级高，会覆盖组件创建器设置的属性
			'nickname'	=>'qingcms'
		],
	],
	//一些配置信息
	'configs'=>[]
];
?>
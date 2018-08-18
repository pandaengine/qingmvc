<?php
/**
 * 应用配置
 * 完整版
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
include __DIR__.'/main.configs.php';
//
return array(
	//模块基础路径
	'basePath'	 =>__DIR__.'/..',
	//时区
	'timezone'	 =>'PRC',
	//应用命名空间
	'namespace'  =>'\main',
	//命名空间映射
	'namespaces' =>
	[
		'qingtpl'=>'/qingtpl/src'
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
	//启动程序
	'startup'=>__DIR__.'/main.startup.php',
	//拦截器
	'interceptors'=>
	[
		
	],
	//组件列表
	'components'=>
	[
		//默认数据库连接
		'db@main'=>include __DIR__.'/main.db.php',
		//url别名
		'url_alias'=>
		[
			'class'=>'\qing\url\creators\UrlAlias',
			'maps' =>
			[
				'login2@index'=>'login2',
				'u@Index@index'=>'user',
				'reg@index'=>'reg',
				'home@index'=>function(&$params){
					$url=vsprintf('home/%s/%s',[$params['id'],$params['username']]);
					unset($params['id']);
					unset($params['username']);
					return $url;
				}
			]
		],
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
		]
	],
	//一些配置信息
	'configs'=>$common_config
);
?>
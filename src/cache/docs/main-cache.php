<?php
/**
 * 缓存配置
 */
return array(
		'config'	=>array(
						'driver'             => 'redis',     // 缓存驱动
						'host'               => '127.0.0.1', // 服务器地址
						'port'               => '6379',      // 端口
						'expire'             => '',           // 连接持续（超时）时间，单位秒。
						'prefix'             => '',          // 键值前缀
				),
		'links' =>array(
				"queryCache"=>array(
						'driver'             => 'file',  // 缓存驱动
						'host'               => APP_ROOT.'/../~runtime/~admin/~query', // 服务器地址
						'port'               => '',     // 端口
						'expire'             => '',     // 连接持续（超时）时间，单位秒。
						'prefix'             => '',     // 键值前缀
				),
				"rbac"=>array(
						'driver'             => 'file',  // 缓存驱动
// 						'host'               => APP_ROOT.'/../~runtime/~admin/~query', // 服务器地址
						'host'               => '', // 服务器地址
						'port'               => '',     // 端口
						'expire'             => '',     // 连接持续（超时）时间，单位秒。
						'prefix'             => '',     // 键值前缀
				),
		)	
);
?>
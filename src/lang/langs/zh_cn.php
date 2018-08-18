<?php 
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
return
[
	'system_error'			=>'系统错误',
	'nonsupport'			=>'不支持',
	//error
	'error_already_exist'	=>'已经存在',
	'error_captcha'			=>'验证码错误',
	'error_not_unique'		=>'已经存在',
	'error_token'			=>'令牌错误，请刷新重试',
	//
	'action_forbidden'		=>'控制器操作禁止访问',
	'action_notfound'		=>'控制器操作不存在',
	'ctrl_forbidden'		=>'控制器禁止访问',
	'ctrl_notfound'			=>'控制器不存在',
	//http
	'http_forbidden403'			=>'页面禁止访问',
	'http_found302'				=>'页面临时转移，页面已找到',
	'http_method_limit'			=>'限制请求方式为',
	'http_movedpermanently301'	=>'页面已永久转移',
	'http_notfound404'			=>'请求不存在',
	'http_service_error_500'	=>'服务器错误',
	'http_service_error_503'	=>'服务不可用',
	//view
	'view_cannot_parse'			=>'视图不能解析',
	'view_finder_notfound'		=>'视图文件定位器不存在',
	'view_layoutfile_notfound'	=>'布局文件不存在',
	'view_resolver_notfound'	=>'视图解析器不存在',
	'view_viewfile_notfound'	=>'视图文件不存在',
	//
	'excp_file_notfound'			=>'找不到文件或目录',
	//class
	'class_file_notfound'			=>'类文件不存在',
	'class_method_notfound'			=>'类成员方法不存在',
	'class_not_instantiable'		=>'类不能实例化',
	'class_notfound'				=>'类不存在',
	'class_property_notfound'		=>'类属性不存在',
	'class_static_method_notfound'	=>'类静态成员方法不存在',
	//
	'object_invalid'				=>'不是对象',
	'instance_conf_nonclass'		=>'实例配置信息必须包含[class]选项',
	'arr_item_notfound'				=>'数组元素不存在',
	//
	'msg_error'		=>'操作失败',
	'msg_success'	=>'操作成功',
	'msg_title'		=>'提示信息-',
	//
	'datatype_mustbe_array'		=>'必须是数组',
	'datatype_mustbe_boolean'	=>'必须是布尔值',
	'datatype_mustbe_number'	=>'必须是数字',
	'datatype_mustbe_string'	=>'必须是字符串',
	//vld
	'vld_required'    		=>'不能为空',
	'vld_email_invalid'		=>'邮箱格式错误',
	'vld_guid_invalid'		=>'guid格式错误',
	'vld_invalid'			=>'验证不通过',
	'vld_ip_invalid'		=>'IP格式错误',
	'vld_string_len_invalid'=>'字符串长度不匹配',
	//
	'vld_number_toobig'		=>'数字太大',
	'vld_number_toosmall'	=>'数字太小',
	'vld_string_len_invalid'=>'字符串长度不匹配',
	'vld_string_toolong'	=>'字符串长度太长',
	'vld_string_tooshort'	=>'字符串长度太短',
	//
	'filter_notfound'		=>'过滤器不存在',
	'cache_notfound'		=>'缓存连接不存在',
	'filesys_mkdir_err'		=>'创建目录失败'	
];
?>
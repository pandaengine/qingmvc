<?php 
namespace qing\session;
use qing\com\ComCreator;
use qing\filesystem\MK;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SessionCreator extends ComCreator{
	/**
	 * @see \qing\com\ComCreator::create()
	 */
	public function create(){
		$session=new Session();
		$session->session_name='sessionid';
		
		//#会话文件的保存路径,默认/tmp
		$sesspath=APP_RUNTIME;
		$sesspath=$sesspath.DS.'~sess';
		MK::dir($sesspath);
		$session->save_path($sesspath);
		
		//#会话生命周期/10s/0 表示'直到关闭浏览器'
		$session->lifetime(10);
		$session->cookie_path('/');
		$session->cookie_domain('.qingmvc.com');
		
		//#自定义会话管理处理器
		//$handler=new \qing\session\handler\RedisHandler();
		//$handler=new \qing\session\handler\DbHandler();
		//$handler->lifetime=$lifetime;
		//$session->save_handler($handler);
		
		return $session;
	}
}
?>
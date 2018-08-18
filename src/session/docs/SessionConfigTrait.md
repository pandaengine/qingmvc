<?php 
namespace qing\session;
/**
 * Session组件
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
trait SessionConfigTrait{
	/**
	 * 设置自定义处理驱动|Redis/Cache/Mysql/Db
	 * 
	 * 获取持久化处理器驱动
	 * db/session/file/redis
	 * 
	 * 设置用户自定义会话存储函数|使用对象
	 *
	 * \SessionHandlerInterface
	 * \SessionHandler
	 *
	 * @param \SessionHandlerInterface $sessionhandler 接口的对象|实现session操作的各个方法
	 * @param bool $register_shutdown
	 * 将函数 session_write_close() 注册为 register_shutdown_function() 函数
	 * 代码执行结束后调用session_write_close保存持久化session数据
	 */
	public function setSaveHandler(\SessionHandlerInterface $sessionhandler,$register_shutdown=true){
		session_set_save_handler($sessionhandler,$register_shutdown);
	}
	/**
	 * 设置会话过期时间，单位秒/s；60*60*24=24h
	 * 过期后session文件和cookie均被清除
	 * -----------------------
	 * session.gc_maxlifetime ：默认1440s/24min/指定过了多少秒之后数据就会被视为'垃圾'并被清除。
	 * session.cookie_lifetime：cookie过期时间
	 * -----------------------
	 * 会覆盖$session_cookie_lifetime配置
	 *
	 * ---------------------------------------------------
	 * # 设置session生命周期
	 * # 执行回收器gc的生命周期
	 *
	 * - session过期事件
	 * - session.gc_maxlifetime:
	 * - 和session.gc_probability/session.gc_divisor概率有关，
	 * - 例如 1/100 意味着在每个请求中有 1% 的概率启动 gc进程。
	 * ---------------------------------------------------
	 * 设置会话cookie过期时间；会覆盖$session_cookie[0]；60*60*24=24h
	 *
	 * session.cookie_lifetime
	 * 以秒数指定了发送到浏览器的 cookie的生命周期；值为 0 表示'直到关闭浏览器'；默认为 0。
	 *
	 * @param number $lifetime
	 */
	public function setLifetime($lifetime){
		//#回收机制周期
		ini_set('session.gc_maxlifetime',$lifetime);
		//cookie过期时间
		ini_set('session.cookie_lifetime',$lifetime);
	}
}
?>
<?php 
namespace qing\session;
/**
 * - session帮助类
 * - 系统函数解释
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SessionHelper{
	/**
	 * - 获取/设置当前会话 ID
	 * - 必须在调用 session_start() 函数之前调用 session_id()函数。
	 * -session_id() 返回当前会话ID。 如果当前没有会话，则返回空字符串（""）。
	 * 
	 * @param mixed $id
	 * null：返回，否则设置
	 * 不同的会话管理器对于会话 ID中可以使用的字符有不同的限制。
	 * 例如文件会话管理器仅允许会话 ID 中使用以下字符：a-z A-Z 0-9 , （逗号）和 - （减号）。
	 * 会话管理器:文件、数据库、memcache
	 * 
	 * @return string
	 */
	public function session_id($id=null){
		if($id===null){
			return session_id();
		}else{
			session_id($id);
		}
	}
	/**
	 * session_encode—将当前会话数据编码为一个字符串
	 * session_encode() 返回一个序列化后的字符串，包含被编码的、储存于 $_SESSION 超全局变量中的当前会话数据。
	 * 请注意，序列方法 和 serialize()是不一样的。 该序列方法是内置于 PHP 的，能够通过设置 session.serialize_handler 来设置。
	 * Warning 在调用 session_decode() 之前必须先调用 session_start()。
	 * 
	 * @return string 返回当前会话编码后的内容。
	 */
	public function session_encode(){
		return session_encode();
	}
	/**
	 * session_decode — 解码会话数据
	 * session_decode() 对 $data 参数中的已经序列化的会话数据进行解码， 并且使用解码后的数据填充 $_SESSION 超级全局变量。
	 *
	 * @param mixed $data  编码后的数据
	 * @return boolean 成功时返回 TRUE， 或者在失败时返回 FALSE。
	 */
	public function session_decode($data){
		return session_decode($data);
	}
	/**
	 * 设置用户自定义会话存储函数
	 *
	 * @param callable $open
	 * @param callable $close
	 * @param callable $read
	 * @param callable $write
	 * @param callable $destroy
	 * @param callable $gc
	 */
	public function session_set_save_handler_function($open, $close, $read, $write, $destroy, $gc){
		session_set_save_handler($open, $close, $read, $write, $destroy, $gc);
	}
	/**
	 * 读取/设置当前会话的保存路径,指定会话数据保存的路径。
	 * 必须在调用 session_start() 函数之前调用 session_save_path() 函数。
	 *
	 * @param string $path
	 * @return string
	 */
	public function session_save_path($path=''){
		if($path>''){
			session_save_path($path);
			return true;
		}else{
			return session_save_path();
		}
	}
	/**
	 * 获取会话 cookie参数
	 * --------------
	 * 返回一个包含当前会话 cookie 信息的数组：
	 * 1. "lifetime" - cookie 的生命周期，以秒为单位。
	 * 2. "path" 	 - cookie 的访问路径。
	 * 3. "domain"   - cookie 的域。
	 * 4. "secure"   - 仅在使用安全连接时发送 cookie。
	 * 5. "httponly" - 只能通过 http 协议访问 cookie
	 */
	public function session_get_cookie_params(){
		return session_get_cookie_params();
	}
	/**
	 * 设置会话 cookie 参数
	 * ---------------
	 * Cookie 参数可以在 php.ini 文件中定义，本函数仅在当前脚本执行过程中有效。
	 * 因此，如果要通过函数修改 cookie 参数，需要对每个请求都要 在调用 session_start() 函数之前调用 session_set_cookie_params() 函数。
	 * 本函数会修改运行期 ini 设置值， 可以通过 ini_get() 函数获取这些值。
	 *
	 * @param number $lifetime  默认0;   Cookie 的 生命周期，以秒为单位。
	 * @param string $path		默认/;   此 cookie 的有效路径。默认"/"，表示对于本域上所有的路径此 cookie 都可用。
	 * @param string $domain	默认'';  Cookie 的作用 域。 例如：“www.php.net”。 如果要让 cookie 在所有的子域中都可用，此参数必须以点（.）开头，例如：“.php.net”。
	 * @param string $secure	默认false; 设置为 TRUE 表示 cookie 仅在使用 安全 链接时可用。
	 * @param string $httponly  默认false; 设置为 TRUE 表示 PHP 发送 cookie 的时候会使用 httponly 标记。
	 */
	public function session_set_cookie_params($lifetime,$path='/',$domain='',$secure=false,$httponly=false){
		return session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly);
	}
}
?>
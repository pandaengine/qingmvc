<?php
namespace qing\session\handler;
use qing\db\Model;
/**
 * 自定义session驱动处理器|数据库驱动
 * 

CREATE TABLE `pre_session`(
  `id` 	   char(50) NOT NULL DEFAULT '' COMMENT 'sessionID',
  `value`  text NULL COMMENT 'session数据',
  `expire` int(11) NOT NULL DEFAULT '0' COMMENT 'session过期时间',
  PRIMARY KEY (`id`) COMMENT "主键"
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT="session表";

 * 
 * @deprecated 不推荐，请使用高并发高速缓存代替，redis/memcache
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class DbHandler extends Model implements \SessionHandlerInterface{
	/**
	 * @var string
	 */
	protected $tableName='session';
	/**
	 * 数据库连接
	 * - 默认为默认连接
	 * - 可设置不同的会话数据库主机，和主数据库分开
	 *
	 * @var string
	 */
	protected $connName;
	/**
	 * session生命周期/单位s/24*3600
	 * 
	 * @var number
	 */
	public $expire=0;
	/**
	 * 初始化session
	 * session_start();后自动调用
	 * 
	 * @param save_path string  保存位置
	 * @param name string session名称
	 * @return bool
	 */
	public function open($save_path,$name){
		//$db=$this->getDb();
		//关闭db的自动关闭
		//session::write和session::close都是在脚本执行完成(script die)后才调用的
		//避免数据库已经关闭。
		//$db->autoClose(false);
		return true;
	}
	/**
	 * 读取session数据
	 * - 调用session_start();后自动读取数据到数组$_SESSION
	 * SELECT session_value FROM __TABLE__ WHERE session_id='{$session_id}' AND session_expire>'{$time}'
	 * debug_print_backtrace();
	 * 
	 * @param session_id 
	 * @return string 编码的字符串型数据|或者空
	 */
	public function read($session_id){
		$data=$this->where(['id'=>$session_id])->find();
		$expire=(int)$data['expire'];
		if($expire==0 || $expire>time()){
			//session还未过期
			return $data['value'];
		}
		return null;
	}
	/**
	 * 写入数据
	 * 脚本执行完成后
	 * 
	 * 当脚本执行接受后，调用各个实例的析构函数，dbconn可能已被析构！
	 * 
	 * ---
	 * - mysqli::query(): Couldn't fetch mysqli
	 * - You're trying to use a database object that you've already closed 
	 * ---
	 * - session::write和session::close都是在脚本执行完成(script die)后才调用的/数据库已经关闭了。
	 * 
	 * @param session_id
	 * @param session_value session数据
	 * @return bool
	 */
	public function write($session_id,$session_value){
		if($this->expire>0){
			$expire=time()+$this->expire;
		}else{
			$expire=0;
		}
		return $this->replace(['id'=>$session_id,'value'=>$session_value,'expire'=>$expire]);
	}
	/**
	 * 关闭session
	 * 
	 * @return bool
	 */
	public function close(){
		return $this->getConn()->close();
	}
	/**
	 * 销毁session
	 * 
	 * @param session_id
	 * @return bool
	 */
	public function destroy($session_id){
		return $this->where(['id'=>$session_id])->delete();
	}
	/**
	 * 清除销毁老的session数据
	 * 
	 * @param maxlifetime int
	 * @return bool
	 */
	public function gc($maxlifetime){
		return $this->where('session_expire<'.$maxlifetime)->delete();
	}
}
?>
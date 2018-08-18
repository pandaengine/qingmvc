<?php
namespace qing\session\handler;
use qing\com\Component;
use qing\filesystem\MK;
/**
 * 文件会话管理器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FileHandler extends Component implements \SessionHandlerInterface{
	/**
	 * session文件路径
	 * 
	 * @var string
	 */
	private $savePath;
	/**
	 */
	protected function getSessionFile($session_id){
		return $this->savePath.'/sess_'.$session_id;
	}
	/**
	 * 初始化会话
	 * 
	 * @see SessionHandlerInterface::open()
	 * @param string $session_name 会话名称/PHPSESSID
	 */
	public function open($save_path,$session_name){
		$this->savePath=$save_path;
		MK::dir($save_path);
		return true;
	}
	/**
	 * 读取会话数据
	 * 
	 * @see SessionHandlerInterface::read()
	 */
	public function read($session_id){
		return (string)@file_get_contents($this->getSessionFile($session_id));
	}
	/**
	 * 写入会话数据
	 * 
	 * @see SessionHandlerInterface::write()
	 */
	public function write($session_id,$session_data){
		return file_put_contents($this->getSessionFile($session_id))===false?false:true;
	}
	/**
	 * 关闭会话
	 * 
	 * @see SessionHandlerInterface::close()
	 */
	public function close(){
		return true;
	}
	/**
	 * 销毁会话
	 * 
	 * @see SessionHandlerInterface::destroy()
	 */
	public function destroy($session_id){
		$file=$this->getSessionFile($session_id);
		if(file_exists($file)){
			unlink($file);
		}
		return true;
	}
	/**
	 * 清理过期会话
	 * 
	 * glob-寻找与模式匹配的文件路径
	 * 
	 * @see SessionHandlerInterface::gc()
	 */
	public function gc($maxlifetime){
		foreach(glob($this->savePath.'/sess_*') as $file){
			if(file_exists($file) && filemtime($file)+$maxlifetime<time()){
				//删除已过期文件
				unlink($file);
			}
		}
		return true;
	}
}
?>
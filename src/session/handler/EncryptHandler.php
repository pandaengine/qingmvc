<?php
namespace qing\session\handler;
/**
 * 文件会话管理器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class EncryptHandler extends \SessionHandler{
	/**
	 * 加密解密密码
	 * 
	 * @var string
	 */
	private $authKey;
	/**
	 * 解密数据
	 * 
	 * @param string $data
	 */
	public function decrypt($data){
		//return func_decrypt($data,$this->authKey);
	}
	/**
	 * 加密数据
	 *
	 * @param string $data
	 */
	public function encrypt($data){
		//return func_encrypt($data,$this->authKey);
	}
	/**
	 * 读取会话数据并解密
	 * 
	 * @see SessionHandler::read()
	 */
	public function read($session_id){
		$data=parent::read($session_id);
		if(!$data){
			return '';
		}else{
			//解密数据 
			return $this->decrypt($data);
		}
	}
	/**
	 * 加密会话数据并写入
	 * 
	 * @see SessionHandler::write()
	 */
	public function write($session_id,$data){
		$data=$this->encrypt($data);
		return parent::write($session_id,$data);
	}
}
?>
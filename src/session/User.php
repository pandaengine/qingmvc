<?php
namespace qing\session;
use qing\com\Component;
/**
 * 用户会话组件
 * 使用主动式持久化
 * 
 * @todo 把用户会话数据保存到一个数组，每次从数组中恢复数据即可
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class User extends Component{
	/**
	 * 数据键值
	 * 
	 * @var string
	 */
	public $sessionKey='_user_';
	/**
	 * session组件名称
	 * 
	 * @var string
	 */
	public $sessionCom='session';
	/**
	 * @var \qing\session\Session
	 */
	protected $_session;
	/**
	 * 用户id/uid
	 * 
	 * @var int
	 */
	public $uid=0;
	/**
	 * 用户名称/name/username
	 * 
	 * @var string
	 */
	public $username='';
	/**
	 * 用户昵称
	 *
	 * @var string
	 */
	public $nickname='';
	/**
	 * 用户组ID
	 * 
	 * @name group
	 * @var int
	 */
	public $gid=0;
	/**
	 * 是否是管理员
	 *
	 * @var int
	 */
	public $admin=0;
	/**
	 * 用户会话状态/登录状态
	 *
	 * @var int
	 */
	public $status=0;
	/**
	 * @return array
	 */
	public static function dataFields(){
		$fields=
		[
			'uid'		=>'int',
			'username'	=>'string',
			'nickname'	=>'string',
			'gid'		=>'int',
			'admin'		=>'int',
			'status'	=>'int'
		];
		return $fields;
	}
	/**
	 * 
	 * @see \qing\com\Component::initComponent()
	 */
	public function initComponent(){
		$this->_session=com($this->sessionCom);
		if($_SESSION && isset($_SESSION[$this->sessionKey])){
			$this->recover();
		}
	}
	/**
	 * 恢复数据
	 * 从会话数据中恢复用户会话数据
	 */
	protected function recover(){
		$fields=self::dataFields();
		$datas=(array)$_SESSION[$this->sessionKey];
		foreach($datas as $k=>$v){
			if(isset($fields[$k])){
				$this->recoverProp($k,$v,$fields[$k]);
			}
		}
	}
	/**
	 * 初始化属性
	 * 从会话数据中恢复数据设置属性
	 *
	 * @param string $key
	 * @param string $value
	 * @param string $type
	 */
	protected function recoverProp($key,$value,$type='string'){
		if($value!==null){
			//不等于null才设置
			//格式化数据
			switch($type){
				case 'int':$value=(int)$value;break;
				case 'float':$value=(float)$value;break;
				case 'bool':$value=(bool)$value;break;
				case 'string':
				default:$value=(string)$value;break;
			}
			$this->$key=$value;
		}
	}
	/**
	 * 设置属性
	 * 并持久化数据到会话数据
	 * 主动式更新,主动持久化
	 *
	 * @param  $key
	 * @param  $value
	 */
	protected function setProp($key,$value){
		//更改属性
		$this->$key=$value;
		$this->set($key,$value);
	}
	/**
	 * 获取持久化数据
	 *
	 * @param string $key
	 * @return string
	 */
	public function get($key){
		return $_SESSION[$this->sessionKey][$key];
	}
	/**
	 * 持久化数据
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function set($key,$value){
		$_SESSION[$this->sessionKey][$key]=$value;
	}
	/**
	 * 设置uid
	 *
	 * @param number $uid
	 * @return $this
	 */
	public function uid($uid){
		$this->setProp('uid',$uid);
		return $this;
	}
	/**
	 * 设置username
	 *
	 * @param string $username
	 * @return $this
	 */
	public function username($username){
		$this->setProp('username',$username);
		return $this;
	}
	/**
	 * 设置admin
	 *
	 * @param boolean $admin
	 * @return $this
	 */
	public function admin($admin){
		$this->setProp('admin',$admin);
		return $this;
	}
	/**
	 * 设置 gid
	 *
	 * @param string $gid
	 * @return $this
	 */
	public function gid($gid){
		$this->setProp('gid',$gid);
		return $this;
	}
	/**
	 * 设置nickname
	 *
	 * @param string $nickname
	 * @return $this
	 */
	public function nickname($nickname){
		$this->setProp('nickname',$nickname);
		return $this;
	}
	/**
	 * 设置status
	 *
	 * @param number $status
	 * @return $this
	 */
	public function status($status){
		$this->setProp('status', $status);
		return $this;
	}
	/**
	 * 是否管理员
	 *
	 * @return boolean
	 */
	public function isAdmin(){
		return $this->admin>0;
	}
	/**
	 * 是否已经登录,并且是管理员
	 *
	 * @return boolean
	 */
	public function isAdminLogged(){
		return $this->isAdmin() && $this->isLogged();
	}
	/**
	 * 验证是否已经登录
	 * 
	 * @name logged in
	 * @return boolean
	 */
	public function isLogged(){
		if($this->uid>0){
			return true;
		}
		return false;
	}
	/**
	 * 账户已激活
	 * 
	 * @return boolean
	 */
	public function isActive(){
		if($this->status==1){
			return true;
		}
		return false;
	}
	/**
	 * 执行登录操作
	 * 
	 * @param string $uid 用户id
	 * @param string $username 用户名
	 * @param number $isAdmin 是否是管理员
	 * @return boolean
	 */
	public function login($uid,$username,$admin=0){
		$this->uid($uid)
			 ->username($username)
			 ->admin($admin);
		//重新生成session_id值
		$this->_session->regenerate_id();
		return $this;
	}
	/**
	 * 执行退出
	 * 
	 * @return boolean
	 */
	public function logout(){
		$this->_session->destroy();
		return true;
	}
	/**
	 * rawData 原始数据
	 * 
	 * @return array
	 */
	public function getData(){
		$data=[];
		$fields=self::dataFields();
		foreach($fields as $field=>$type){
			if(property_exists($this,$field)){
				$data[$field]=$this->$field;
			}
		}
		return $data;
	}
}	
?>
<?php 
namespace qing\safe;
/**
 * 密码加盐的好处：
 * - 避免其他地方的md5码对比推测出原始密码
 * - 无法使用碰撞破解密码
 * - 盐是随机的
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class PwdSalt{
	/**
	 * 创建密码
	 * - 返回加密后的密码和盐
	 * - 最终保存到数据库
	 * 
	 * @param string $password 普通原始密码
	 * @return string
	 */
	public static function create($password){
		$salt 	  =self::createSalt();
		$encodePwd=self::encode($password,$salt);
		return [$encodePwd,$salt];
	}
	/**
	 * 检测密码正确与否
	 *
	 * @param string $password 	  普通原始密码
	 * @param string $_encodePwd 数据库中编码后的密码
	 * @param string $_salt 	   数据库中编码密码的盐
	 * @return boolean
	 */
	public static function check($password,$_encodePwd,$_salt){
		return self::encode($password,$_salt)==$_encodePwd;
	}
	/**
	 * 编码普通原始密码和盐
	 *
	 * @param string $password
	 * @param string $salt
	 * @return string 编码后的密码
	 */
	public static function encode($password,$salt){
		return md5(md5($password).$salt);
	}
	/**
	 * 创建盐
	 *
	 * @return string
	 */
	public static function createSalt(){
		return substr(uniqid(rand()),-6);
	}
}
?>
<?php 
namespace qing\utils;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ID{
	/**
	 * 1.生成唯一ID的算法
	 * 2.废弃：md5(time()) 基于时间的都有可能重复，高并发下
	 * 3.md5并不会影响其的唯一性
	 * 4.prefix为空，则返回的字符串长度为13;more_entropy 为 TRUE，则返回的字符串长度为23。
	 *
	 * @param $pre 			前缀，一般需要加上前缀才能更严谨的表示唯一;加上uid
	 * @param $md5 			是否对字符串加密
	 * @param $more_entropy 如果设置为 TRUE，uniqid() 会在返回的字符串结尾增加额外的煽
	 * @return string
	 */
	static public function uniqueId($pre=null,$md5=true,$more_entropy=true){
		if($md5){
			return md5(uniqid($pre,$more_entropy));
		}else{
			return uniqid($pre,$more_entropy);
		}
	}
	static public function uniqueId2() {
		$data=$_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'].time().rand();
		return sha1($data);
		//return md5(time().$data);
		//return $data;
	}
	/**
	 * 
	 * @param string $namespace
	 * @return string
	 */
	static public function create_guid($namespace = '') {     
	     $guid = '';
	     $uid = uniqid("", true);
	     $data = $namespace;
	     $data .= $_SERVER['REQUEST_TIME'];
	     $data .= $_SERVER['HTTP_USER_AGENT'];
	     $data .= $_SERVER['LOCAL_ADDR'];
	     $data .= $_SERVER['LOCAL_PORT'];
	     $data .= $_SERVER['REMOTE_ADDR'];
	     $data .= $_SERVER['REMOTE_PORT'];
	     $hash = strtoupper(hash('ripemd128',$uid.$guid.md5($data)));
	     $guid = '{' .   
	             substr($hash,  0,  8) . 
	             '-' .
	             substr($hash,  8,  4) .
	             '-' .
	             substr($hash, 12,  4) .
	             '-' .
	             substr($hash, 16,  4) .
	             '-' .
	             substr($hash, 20, 12) .
	             '}';
	     return $guid;
	   }
	/**
	 * GUID:
	 * - 全局唯一标识符（GUID，Globally Unique Identifier）是一种由算法生成的二进制长度为128位的数字标识符
	 * - 在理想情况下，任何计算机和计算机集群都不会生成两个相同的GUID
	 * - guid是uuid的一种实现
	 *
	 * UUID:
	 * 含义是通用唯一识别码 (Universally Unique Identifier)
	 *
	 * @name uuid
	 */
	static public function guid(){
		return md5(uniqid(mt_rand(),true));
	}
}
?>
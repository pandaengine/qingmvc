<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Conn extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	public static function getName(){
		return 'db@main';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\db\pdo\Connection 
	 */
	public static function getInstance(){
		
	}
	/**
	 * 
	 */
	public static function connect(){
		return static::getInstance()->connect();
	}
	/**
	 * 
	 */
	public static function query($sql,$bindings=[]){
		return static::getInstance()->query($sql,$bindings);
	}
	/**
	 * 
	 */
	public static function execute($sql,$bindings=[]){
		return static::getInstance()->execute($sql,$bindings);
	}
	/**
	 * 
	 */
	public static function free(){
		return static::getInstance()->free();
	}
	/**
	 * 
	 */
	public static function close(){
		return static::getInstance()->close();
	}
	/**
	 * 
	 */
	public static function getInsertId(){
		return static::getInstance()->getInsertId();
	}
	/**
	 * 
	 */
	public static function getAffectedRows(){
		return static::getInstance()->getAffectedRows();
	}
	/**
	 * 
	 */
	public static function getError(){
		return static::getInstance()->getError();
	}
	/**
	 * 
	 */
	public static function autocommit($mode){
		return static::getInstance()->autocommit($mode);
	}
	/**
	 * 
	 */
	public static function begin(){
		return static::getInstance()->begin();
	}
	/**
	 * 
	 */
	public static function commit(){
		return static::getInstance()->commit();
	}
	/**
	 * 
	 */
	public static function rollback(){
		return static::getInstance()->rollback();
	}
	/**
	 * 
	 */
	public static function conn(){
		return static::getInstance()->conn();
	}
	/**
	 * 
	 */
	public static function getConn(){
		return static::getInstance()->getConn();
	}
	/**
	 * 
	 */
	public static function getNumRows(){
		return static::getInstance()->getNumRows();
	}
	/**
	 * 
	 */
	public static function getSql(){
		return static::getInstance()->getSql();
	}
	/**
	 * 
	 */
	public static function setError($error){
		return static::getInstance()->setError($error);
	}
	/**
	 * 
	 */
	public static function getPrefix(){
		return static::getInstance()->getPrefix();
	}
	/**
	 * 
	 */
	public static function getSqlBuilder(){
		return static::getInstance()->getSqlBuilder();
	}
	/**
	 * 
	 */
	public static function reset(){
		return static::getInstance()->reset();
	}
	/**
	 * 
	 */
	public static function autoClose($value){
		return static::getInstance()->autoClose($value);
	}
	/**
	 * 
	 */
	public static function comName($comName){
		return static::getInstance()->comName($comName);
	}
	/**
	 * 
	 */
	public static function className(){
		return static::getInstance()->className();
	}
}
?>
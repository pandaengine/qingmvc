<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class BaseModel extends FacadeSgt{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	public static function getName(){
		return '\qing\db\BaseModel';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\db\BaseModel 
	 */
	public static function getInstance(){
		
	}
	/**
	 * 
	 */
	public static function connName($conn){
		return static::getInstance()->connName($conn);
	}
	/**
	 * 
	 */
	public static function cacheName($conn){
		return static::getInstance()->cacheName($conn);
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
	public static function setError($error){
		return static::getInstance()->setError($error);
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
	public static function getSql(){
		return static::getInstance()->getSql();
	}
	/**
	 * 
	 */
	public static function getConnError(){
		return static::getInstance()->getConnError();
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
	public static function getNumRows(){
		return static::getInstance()->getNumRows();
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
	public static function queryRow($sql,$bindings=[]){
		return static::getInstance()->queryRow($sql,$bindings);
	}
	/**
	 * 
	 */
	public static function queryField($sql,$bindings=[],$field=''){
		return static::getInstance()->queryField($sql,$bindings,$field);
	}
	/**
	 * 
	 */
	public static function dropTable($table){
		return static::getInstance()->dropTable($table);
	}
	/**
	 * 
	 */
	public static function truncateTable($table){
		return static::getInstance()->truncateTable($table);
	}
	/**
	 * 
	 */
	public static function lockTablesRead($table,$local=''){
		return static::getInstance()->lockTablesRead($table,$local);
	}
	/**
	 * 
	 */
	public static function lockTablesWrite($table){
		return static::getInstance()->lockTablesWrite($table);
	}
	/**
	 * 
	 */
	public static function unlockTables(){
		return static::getInstance()->unlockTables();
	}
	/**
	 * 
	 */
	public static function cache($id,$callback,$expire=0){
		return static::getInstance()->cache($id,$callback,$expire);
	}
	/**
	 * 
	 */
	public static function comName($comName){
		return static::getInstance()->comName($comName);
	}
}
?>
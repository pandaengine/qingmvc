<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 * 注意：
 * - 只需要tip需要继承BaseModel，用于提示
 * - 生产，不需要
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Model extends FacadeSgt{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	public static function getName(){
		return '\qing\db\Model';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\db\Model 
	 */
	public static function getInstance(){
		
	}
	/**
	 * 
	 */
	public static function getFields($fields=''){
		return static::getInstance()->getFields($fields);
	}
	/**
	 * 
	 */
	public static function tableAlias($alias){
		return static::getInstance()->tableAlias($alias);
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
	public static function getTableName(){
		return static::getInstance()->getTableName();
	}
	/**
	 * 
	 */
	public static function getRealTableName(){
		return static::getInstance()->getRealTableName();
	}
	/**
	 * 
	 */
	public static function sqlBuilder(){
		return static::getInstance()->sqlBuilder();
	}
	/**
	 * 
	 */
	public static function table($table){
		return static::getInstance()->table($table);
	}
	/**
	 * 
	 */
	public static function where($value){
		return static::getInstance()->where($value);
	}
	/**
	 * 
	 */
	public static function where_conn($conn='or'){
		return static::getInstance()->where_conn($conn);
	}
	/**
	 * 
	 */
	public static function fields($value){
		return static::getInstance()->fields($value);
	}
	/**
	 * 
	 */
	public static function orderby($value){
		return static::getInstance()->orderby($value);
	}
	/**
	 * 
	 */
	public static function limit($value){
		return static::getInstance()->limit($value);
	}
	/**
	 * 
	 */
	public static function select(){
		return static::getInstance()->select();
	}
	/**
	 * 
	 */
	public static function find(){
		return static::getInstance()->find();
	}
	/**
	 * 
	 */
	public static function findField($field){
		return static::getInstance()->findField($field);
	}
	/**
	 * 
	 */
	public static function replace($data){
		return static::getInstance()->replace($data);
	}
	/**
	 * 
	 */
	public static function insert($data,$action='insert'){
		return static::getInstance()->insert($data,$action);
	}
	/**
	 * 
	 */
	public static function insertUpdate($data,$updates){
		return static::getInstance()->insertUpdate($data,$updates);
	}
	/**
	 * 
	 */
	public static function updateField($field,$value){
		return static::getInstance()->updateField($field,$value);
	}
	/**
	 * 
	 */
	public static function update($data=[]){
		return static::getInstance()->update($data);
	}
	/**
	 * 
	 */
	public static function set($value){
		return static::getInstance()->set($value);
	}
	/**
	 * 
	 */
	public static function inc($field){
		return static::getInstance()->inc($field);
	}
	/**
	 * 
	 */
	public static function dec($field){
		return static::getInstance()->dec($field);
	}
	/**
	 * 
	 */
	public static function delete(){
		return static::getInstance()->delete();
	}
	/**
	 * 
	 */
	public static function count(){
		return static::getInstance()->count();
	}
	/**
	 * 
	 */
	public static function has(){
		return static::getInstance()->has();
	}
	/**
	 * 
	 */
	public static function exists(){
		return static::getInstance()->exists();
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
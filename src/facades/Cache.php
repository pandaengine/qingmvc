<?php
namespace qing\facades;
exit('do not use it! only for tip! '.__FILE__);
/**
 *
 * @see \qing\cache\file\FileCache
 */
class Cache extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return 'cache@main';
	}
	/**
	 * 获取组件 
	 * 
	 * @return \qing\cache\file\FileCache 
	 */
	static protected function getInstance(){
		
	}
}
?>
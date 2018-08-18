<?php
namespace qing\facades;
/**
 *
 * @see \qing\di\Container
 */
class Container extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return 'container';
	}
}
?>
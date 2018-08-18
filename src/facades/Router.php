<?php
namespace qing\facades;
/**
 *
 * @see \qing\router\Router
 */
class Router extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return 'router';
	}
}
?>
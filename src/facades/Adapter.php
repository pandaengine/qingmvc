<?php
namespace qing\facades;
/**
 *
 * @see \qing\adapter\ControllerAdapter
 */
class Adapter extends Facade{
	/**
	 * 组件id 
	 * 
	 * @return string 
	 */
	static protected function getName(){
		return 'adapter';
	}
}
?>
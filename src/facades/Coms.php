<?php
namespace qing\facades;
/**
 * 组件管理器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Coms extends Facade{
	/**
	 * @return string
	 */
	protected static function getName(){
		return '';
	}
	/**
	 * @param string $name
	 * @return \qing\com\Coms
	 */
	protected static function instance(){
		//return coms();
		return \qing\Qing::$coms;
	}
	/**
	 * user权限组件
	 *
	 * @return \qing\session_user\UserSession
	 */
	static public function user(){
		return static::instance()->get('user');
	}
	/**
	 * 语言组件
	 *
	 * @return \qing\i18n\I18n
	 */
	static public function i18n(){
		return static::instance()->get('i18n');
	}
	/**
	 * @return \qing\lang\Lang
	 */
	static public function lang(){
		return static::instance()->get('lang');
	}
}
?>
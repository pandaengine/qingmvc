<?php
/**
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright 2013 qingmvc http://qingmvc.com
 */
/**
 * session组件
 *
 * @return \qing\session\Session
 */
function session($app=MAIN_APP){
	return coms($app)->getSession();
}
/**
 * 设置session的值
 *
 * @param string $key
 * @param string $value
 * @param boolean $commit 是否要提交
 */
function set_session($key,$value,$commit=false){
	session()->set($key,$value);
}
/**
 *
 * @param string $key
 */
function get_session($key){
	return session()->get($key);
}
/**
 *
 */
function destroy_session(){
	return session()->destroy();
}
?>
<?php
/**
 * @return \qing\base\Configs
 */
function configs(){
	return coms()->getConfigs();
}
/**
 * 取得配置信息
 *
 * @param string $key
 */
function config($key){
	return get_config($key);
}
/**
 * 取得配置信息
 *
 * @param string $key
 */
function get_config($key){
	return coms()->getConfigs()->get($key);
}
/**
 *
 * @param string $key
 * @param string $value
 */
function set_config($key,$value){
	return coms()->getConfigs()->set($key,$value);
}
?>
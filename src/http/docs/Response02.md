/**
 * 开启缓存
 * 304 not modified
 * Public指示响应可被任何缓存区缓存。
 * private、no-cache、max-age、must-revalidate等，默认为private
 * Cache-control: max-age=5(表示当访问此网页后的5秒内再次访问不会去服务器)
 * //格式化 GMT/UTC 日期和时间，并返回已格式化的日期字符串：gmdate($format);
 * header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
 *
 Expires 的一个缺点就是，返回的到期时间是服务器端的时间，这样存在一个问题，
 如果浏览器所在机器的时间与服务器的时间相差很大，那么误差就很大，
 所以在HTTP 1.1版开始，使用Cache-Control: max-age替代。
 注： 如果max-age和Expires同时存在，则被Cache-Control的max-age覆盖。

 * #必须设置Expires，php默认返回过期日期
 * 注意：所有php返回的响应中默认Expires: Thu, 19 Nov 1981 08:52:00 GMT，避免缓存php页面，除非主动设置
 *
 * @param number $expire 单位秒
 */
public function cacheOn($expire=3600){
	//header_cache_on();
	header('Cache-Control: public,max-age='.$expire);
	header('Pragma: public');
	header('Expires: '.gmdate('D, d M Y H:i:s',time()+$expire).' GMT');
}
/**
 * 关闭缓存
 * header('Cache-Control: post-check=0, pre-check=0', false);
 *
 * header('Expires: -1');
 * header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
 *
 * @param number $expire
 */
public function cacheOff(){
	//header_cache_off();
	header('Cache-Control: private, max-age=0, no-store, no-cache, must-revalidate');
	header('Pragma: no-cache');
	//#设置 一个过期时间
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
}
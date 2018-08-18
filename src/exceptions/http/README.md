web请求异常

-------------------------------------------------------------------------

/**
 *
 * @var array 常用状态码
 */
protected $statusTexts=array(
		// Success 2xx
		200=>'OK',
		// Redirection 3xx
		301=>'Moved Permanently',
		302=>'Found',
		303=>'See Other',
		// Client Error 4xx
		400=>'Bad Request',
		403=>'Forbidden',
		404=>'Not Found',
		405=>'Method Not Allowed',
		// Server Error 5xx
		500=>'Internal Server Error',
		503=>'Service Unavailable'
	);
/**
 *
 * @var array 常用状态码 中文
 */
protected $statusTextsZh=array(
		// Success 2xx
		200=>'请求成功',
		// Redirection 3xx
		301=>'页面已永久转移',
		302=>'页面已找到',
		303=>'See Other',
		// Client Error 4xx
		400=>'错误请求',
		403=>'页面禁止访问',
		404=>'请求不存在',
		405=>'请求方式不允许',
		// Server Error 5xx
		500=>'服务器错误',
		503=>'服务不可用'
);
	
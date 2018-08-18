<?php
/**
 * 继承扩展:系统内置过滤函数集合|PHP|Internal
 * 系统过滤器|系统转义器
 *
 * @name System|Helper
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
/**
 * strip_tags()函数剥去 HTML、XML以及PHP的标签。
 *
 * @name strip tags/剥离标签/strip剥离
 * @param string $value
 * @param string $allow 可选/允许的标签/这些标签不会被删除。
 */
function f_strip_tags($value,$allowtags=''){
	if($allowtags){
		return strip_tags($value,$allowtags);
	}else{
		return strip_tags($value);
	}
}
/**
 * 把一些预定义的字符转换为 HTML 实体。
 * -----------------------
 * 预定义的字符是：
 * & （和号） 成为 &amp;
 * " （双引号） 成为 &quot;
 * ' （单引号） 成为 &#039;
 * < （小于） 成为 &lt;
 * > （大于） 成为 &gt;
 * -------------------------
 * ENT_COMPAT - 默认/仅编码双引号
 * ENT_QUOTES - 编码双引号和单引号
 * ENT_NOQUOTES - 不编码任何引号
 * -------------------------
 * 
 * @name html special chars 转义html特殊字符成实体
 * @name Convert special characters to HTML entities
 * 
 * @param string $value
 * @param string $flags
 * @param string $encoding 字符编码
 * @return string
 */
function f_htmlspecialchars($value,$flags=ENT_QUOTES,$encoding='UTF-8'){
	return htmlspecialchars($value,$flags,$encoding);
}
/**
 * 把字符转换为 HTML实体
 * 
 * - 比htmlspecialchars转换强度大。
 * - 单双引号等转换为实体
 * - \转义符号没有转换!
 * - 避免输出引号<>等影响html展示混乱/变相XSS
 * - 注意：<>和引号引起的XSS
 * 
 * @name html entities | entities实体 
 * @name Convert all applicable characters to HTML entities | 将所有适用的字符为HTML实体
 * @param string $value
 * @param string $flags
 * @param string $encoding 字符编码
 * @return string
 */
function f_htmlentities($value,$flags=ENT_QUOTES,$encoding='UTF-8'){
	return htmlentities($value,$flags,$encoding);
}
/**
 * 转换为实体，除了引号
 * 
 * @param string $value
 * @param string $flags
 * @param string $encoding
 * @return string
 */
function f_htmlentities_noquotes($value,$flags=ENT_NOQUOTES,$encoding='UTF-8'){
	return htmlentities($value,$flags,$encoding);
}
/**
 * 删除由 addslashes()函数给[预定义]字符添加的反斜杠。
 * 反引用一个引用字符串
 * 
 * @param $value
 */
function f_stripslashes($value){
	return stripslashes($value);
}
/**
 * 删除由 addcslashes()函数给[指定Custom]字符添加的反斜杠。
 * 返回反转义后的字符串。可识别类似 C 语言的 \n，\r，... 八进制以及十六进制的描述。
 * 
 * @param $value
 */
function f_stripcslashes($value){
	return stripcslashes($value);
}
/**
 * 在[预定义]的字符前添加反斜杠。
 * 这些预定义字符是：单引号 (')，双引号 (")，反斜杠 (\)，NULL
 * ----------------------------------------------------------
 * $value=' \' " \ NULL '; //单引号实际没有转义，只是为了字符连接
 * result： ' \' \" \\ NULL '
 * ----------------------------------------------------------
 * 
 * @name addslashes | add slashes |添加转义斜线
 * @param $value
 * @return string
 */
function f_addslashes($value){
	return addslashes($value);
}
/**
 * 在[指定]的字符前添加反斜杠。
 * ------------------------------------
 * 在对 0，r，n 和 t 应用 addcslashes() 时要小心。
 * 在 PHP 中，\0，\r，\n 和 \t 是预定义的转义序列。
 * ------------------------------------
 * 
 * @name addcslashes Quote string with slashes in a C style | 以 C 语言风格使用反斜线转义字符串中的字符
 * @param $value
 * @param $characters "
 */
function f_addcslashes($value,$charlist='\'"'){
	return addcslashes($value,$charlist);
}
/**
 * 转义字符串/魔术引号|使用递归/支持多维数组
 * __FUNCTION__/f_addslashes_array
 * 
 * @deprecated
 * @param array|string $value
 */
function f_addslashes_array($value){
	if(is_array($value)){
		return array_map(array($this,__FUNCTION__),$value);
	}
	return $this->f_addslashes($value);
}
// 	/**
// 	 * 魔术引号|转义引号
// 	 * 已自 PHP 5.3.0 起废弃并将自 PHP 5.4.0 起移除。
// 	 * 始终对字符串执行 addslashes()函数
// 	 * 
// 	 * @deprecated
// 	 * @param array|string $value
// 	 */
// 	function f_magic_quotes($value){
// 		return addslashes($value);
// 	}
// 	/**
// 	 * magic_quotes_gpc 为 on，对所有的 GET、POST 和 COOKIE 数据自动运行 addslashes()。
// 	 * 不要对已经被 magic_quotes_gpc 转义过的字符串使用 addslashes()，因为这样会导致双层转义。|【 \\' \\"】单引号又可以用了。
// 	 * 遇到这种情况时可以使用函数 get_magic_quotes_gpc() 进行检测。
// 	 * PHP5.4.0	始终返回 FALSE，因为这个魔术引号功能已经从 PHP 中移除了。
// 	 *
// 	 * @deprecated
// 	 * @param string $value 用户提交的数据$_REQUEST
// 	 */
// 	function f_magic_quotes_gpc($value){
// 		if(!get_magic_quotes_gpc()){
// 			return addslashes($value);
// 		}else{
// 			return $value;
// 		}
// 	}
// 	/**
// 	 * magic_quotes_runtime
// 	 * 如果打开的话，大部份从外部来源取得数据并返回的函数，包括从数据库和文本文件，所返回的数据都会被反斜线转义。
// 	 *
// 	 * @deprecated
// 	 * @param string $value 从文件或数据库读取的数据
// 	 */
// 	function f_magic_quotes_runtime($value){
// 		if(!get_magic_quotes_runtime()){
// 			return addslashes($value);
// 		}else{
// 			return $value;
// 		}
// 	}
?>
<?php
/**
 * 把字符转换为 HTML实体
 *
 * - 比htmlspecialchars转换强度大。
 * - 单双引号等转换为实体
 * - \转义符号没有转换!
 * - 避免输出引号<>等影响html展示混乱/变相XSS
 * - 注意：<>和引号引起的XSS
 *
 * # 注意引号引起的xss|title直接输出导致xss
 * # <a title=""'</a>"></a>
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
?>
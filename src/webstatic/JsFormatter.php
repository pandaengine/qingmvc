<?php
namespace qing\webstatic;
/**
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class JsFormatter extends Formatter{
	/**
	 * 获取js文件内容，并格式化
	 * ------------------------------------------------------------
	 * 后瞻断言 中的正面断言以”(?<=”开始, 消极断言以”(?<!”开始。
	 * (?<!foo)bar 用于查找任何前面不是 ”foo” 的 ”bar”。
	 * (?<=bullock|donkey)bar    查找任何前面是 ”bullock或 donkey ” 的 ”bar”。
	 * ------------------------------------------------------------
	 * s (PCRE_DOTALL) :
	 * 如果设置了这个修饰符，模式中的点号元字符匹配所有字符，包含换行符。
	 * 如果没有这个 修饰符，点号不匹配换行符。
	 *
	 * \s :空白字符
	 * \S :非空白字符
	 *
	 * \s :匹配任何空白字符，包括空格、制表符、换页符等等。等价于 [ \f\n\r\t\v]。
	 * \S :匹配任何非空白字符。等价于 [^ \f\n\r\t\v]。
	 *
	 * ------------------------------------------------------------
	 * '/\/\*.*?\*\//s' : / *  * /多行注释
	 * '/\s{2,}/'		: 两个以上的空格替换成一个空格
	 * '/[\n\r\t\f]/'	:
	 *
	 * @param string $content
	 * @return string
	 */
	protected function formatContent($content){
		//#按行读取
		$lines=explode("\n",$content);
		$text ='';
		foreach($lines as $line){
			//删除单行注释//
			$line=preg_replace('/(?<!http:)\/\/.+/s','',$line);
			$text.=$line;
		}
		$pattern=array(
				'/\/\*.*?\*\//s',
				'/\s{2,}/'
		);
		$replacement=array(
				'',
				' '
		);
		return preg_replace($pattern,$replacement,$text);
	}
}
?>
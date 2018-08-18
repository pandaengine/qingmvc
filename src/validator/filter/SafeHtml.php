<?php
namespace qing\validator\filter;
/**
 * 要返回安全的html，剔除xss/js
 * 
 * @see \qcoms\html\HtmlFilter
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class SafeHtml{
	/**
	 * 返回安全HTML|转义html标签|Xss过滤
	 * return $this->system()->f_htmlspecialchars($value);
	 *
	 * @param string $html
	 * @param string $escape
	 */
	public static function filter($value){
		/*
		$filter=new \qcoms\html\HtmlFilter();
		$filter->removeComments=false;
		$filter->pushAllowTags(['button','center','header','font','time']);
		//#ueditor的背景
		$filter->pushAllowAttrs(['data-background']);
		//#
		$filter->pushAllowStyles(['font-family']);
		return $filter->clean($value);
		*/
	}
}
?>
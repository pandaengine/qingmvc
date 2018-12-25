<?php
namespace qing\interceptors;
use qing\interceptor\Interceptor;
/**
 * - 捕获页面并缓存
 * - 如果页面已经缓存则直接返回不再往下执行
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright 2013 http://qingmvc.com all rights reserved.
 */
class PageCacheInterceptor extends Interceptor{
	/**
	 * @var string
	 */
	protected $pageId;
	/**
	 * 缓存数据的链接
	 *
	 * @var string
	 */
	protected $cacheLink='pageCache';
	/**
	 * @var \qing\http\Request
	 */
	protected $request;
	/**
	 * 
	 * @see \qing\mvc\handler\IInterceptor::preHandle()
	 */
	public function preHandle(){
		$pageId=$this->getPageId();
		//是否已经缓存
		$result=$this->getCache()->get($pageId);
		if($result){
			//#直接输出缓存不往下执行
			echo $result;
			return false;
		}
		//#开启捕获渲染视图内容返回
		ob_start();
		ob_implicit_flush(0);
		return true;
	}
	/**
	 * @see \qing\mvc\handler\IInterceptor::postHandle()
	 */
	public function postHandle(){
	}
	/**
	 * @see \qing\mvc\handler\IInterceptor::afterCompletion()
	 */
	public function afterCompletion(){
		//获取并清空缓存
		$content='';
		if(APP_DEBUG){
			$request   =coms($this->appName)->getRequest();
			$requestUri=$request->getRequestUri();
			$content.="<!-- page: {$requestUri} -->";
		}
		$content.=ob_get_clean();
		//#保存缓存
		$this->getCache()->set($this->getPageId(),$content);
		echo $content;
	}
	/**
	 * 取得当前页面的唯一标识
	 */
	protected function getPageId(){
		if($this->pageId){
			return $this->pageId;
		}
		$request   =coms($this->appName)->getRequest();
		$requestUri=$request->getRequestUri();
		return $this->pageId="pagecache_".md5($requestUri);
	}
	/**
	 * 缓存组件
	 *
	 * @return \qing\cache\Cache
	 */
	protected function getCache(){
		$link=$this->cacheLink;
		$com =coms($this->appName)->getCacheCom();
		if(!$com->hasLink($link)){
			//#默认
			$conf=array();
			$conf['class']='\qing\cache\file\fileCache';
			$conf['host'] =main($this->appName)->getRuntimePath().DS.'~pagecache';
			$com->setLink($link, $conf);
		}
		return $com->getCache($link);
	}
}
?>
<?php
namespace qing\lang;
use qing\interceptor\Interceptor;
use qing\facades\Coms;
/**
 * 语言提示生成拦截器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class TipInterceptor extends Interceptor{
	/**
	 * @var string
	 */
	public $langCom='lang';
	/**
	 * @var string
	 */
	public $lang;
	/**
	 * @see \qing\interceptor\Interceptor::preHandle()
	 */
	public function preHandle(){
		$lang=Coms::lang();
		if(!$this->lang){
			$this->lang=$lang->lang;
		}
		$langs=$lang->initLang($this->lang);
		//
		$content=TipCompiler::compile($langs);
		//
		$tipFile=main()->getBasePath().DS.$lang->langDir.DS.$this->lang.'.tips.php';
		$this->saveCache($tipFile,$content);
		return true;
	}
	/**
	 * 保存缓存
	 *
	 * @param string $cacheFile
	 * @param string $content
	 */
	protected function saveCache($cacheFile,$content){
		//保存为文件
		if(file_put_contents($cacheFile,$content)===false){
			throw new \Exception("保存缓存文件失败：".$cacheFile);
		}
	}
}
?>
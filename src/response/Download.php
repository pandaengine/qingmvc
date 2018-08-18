<?php 
namespace qing\response;
use qing\http\Response;
/**
 * 文件下载响应
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Download extends Response{
	/**
	 * @var string
	 */
	protected $filename;
	/**
	 * 构造函数
	 *
	 * @param string $filename 下载文件名称
	 * @param int    $status   响应状态码/200
	 * @return void
	 */
	public function __construct($filename,$status=200){
		parent::__construct($status);
		//header
		$this->setHeader('Content-Type'			,'application/force-download');
		$this->setHeader('Content-Disposition'	,'attachment; filename='.basename($filename));
	}
	/**
	 * 发送内容主体
	 */
	public function sendContent(){
		$content=@file_get_contents($this->filename);
		echo $content;
	}
}
?>
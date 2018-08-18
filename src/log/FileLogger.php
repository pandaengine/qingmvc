<?php 
namespace qing\log;
use qing\filesystem\MK;
/**
 * 简单的文件日志记录器
 * 
 * @todo 检测文件大小，文件过大则分割
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FileLogger extends Logger{
	/**
	 * 日志文件后缀
	 *
	 * @var string
	 */
	public $fileSuffix='.log';
	/**
	 * 文件名称规则
	 * //固定名称，始终只有一个文件
	 * logfile
	 * //按日期设置
	 * 2014-09-13=date('Y-m-d');  每天一个文件
	 * 2014-42   =date('Y-W');    ISO-8601 格式年份中的第几周
	 * 2014.09   =date('Y-m');    每月一个文件
	 * 2014.09   =date('Y-m');    每年一个文件
	 * //设置目录
	 * 2014/09/13/\l\o\g\f\i\l\e date('Y/m/d/\l\o\g\f\i\l\e');
	 * 
	 * -包括%level%等可替换关键字
	 * -%level%
	 * -%cat%
	 * -日期解析|{{Y-m-d}}
	 * 
	 * -按天保存：
	 * {{Y-m-d}}/log_%level%.log
	 * log_%level%/{{Y-m-d}}.log
	 * -按月保存：
	 * {{Y-m}}/log_%level%.log
	 * log_%level%/{{Y-m}}.log
	 * ---
	 * cat会覆盖level
	 * 
	 * @example
	 * log_%level%_{{Y-m-d}}
	 * %level%/{{Y-m-d}}
	 * 
	 * @var mixed
	 */
	public $saveFileRule='%cat%_{{Y-m-d}}';
	/**
	 * 日志保存目录
	 *
	 * @var string
	 */
	public $savePath;
	/**
	 * @see \qing\com\ComponentInterface::initComponent()
	 */
	public function initComponent(){
		//#文件保存路径
		if(!$this->savePath){
			$savePath=APP_RUNTIME.DS.'~log';
			MK::dir($savePath);
			$this->savePath=$savePath;
		}
	}
	/**
	 * 追加日志|记录日志|log/append
	 *
	 * @param number $level   日志等级
	 * @param string $message 日志消息
	 * @param array  $options
	 */
	public function log($level,$message,array $options=[]){
		$filename=$this->getFileName($level,$options);
		$content =$this->getContent($level,$message,$options);
		//追加内容
		@file_put_contents($filename,$content,FILE_APPEND);
	}
	/**
	 * 取得日志文件名称
	 *
	 * @param number $level   日志等级
	 * @param string $message 日志消息
	 * @param array  $options
	 * @return string
	 */
	protected function getContent($level,$message,array $options){
		//#日志内容
		$date=date('Y-m-d H:i:s',time());
		$log ="[{$date} {$level}] ".$message."\n";
		return $log;
	}
	/**
	 * 取得日志文件名称
	 *
	 * @param string $levelN
	 * @param array $options
	 * @return string
	 */
	protected function getFileName($level,array $options){
		$rule=$this->saveFileRule;
		if(!$rule){
			//#没有规则
			$fileName=strtolower($level);
		}else{
			//#解析规则
			$options['level']=$level;
			if(!isset($options['cat'])){
				$options['cat']=$level;
			}
			//#1占位符解析
			$fileName=preg_replace_callback('/\%([0-9a-z-_]+)\%/i',function($matches)use($options){
				$key=$matches[1];
				if(isset($options[$key])){
					//#找到值替换
					return (string)$options[$key];
				}
				//返回原值
				return $matches[0];
			},$rule);
			//#2日期解析
			$fileName=preg_replace_callback('/\{\{([0-9a-z-_]+)\}\}/i',function($matches){
				$date=(string)$matches[1];
				return date($date);
			},$fileName);
		}
		return $this->savePath.DS.$fileName.$this->fileSuffix;
	}
}
?>
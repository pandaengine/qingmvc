<?php 
namespace qing\console;
use qing\app\App;
use qing\app\traits\InterceptorTrait;
/**
 * 控制台应用
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ConsoleApp extends App{
	use InterceptorTrait;
	/**
	 * 执行
	 */
	public function run(){
		global $argc,$argv;
		if(!isset($argv[1])){
			throw new \Exception('参数过少');
		}
		//命令Id
		$cmdId=$argv[1];
		//剔除前两个参数/0-1
		array_shift($argv);
		array_shift($argv);
		$argBag=new ArgumentBag($argv);
		//var_dump($argBag);
		//dump($argc);dump($argv);
		//exit();
		//(new TipsCommand())->run($argBag);
		(new TablesTpl())->run($argBag);
	}
}
?>
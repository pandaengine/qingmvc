<?php 
namespace qing\utils;
use qing\filesystem\FileName;
/**
 * 打印对象
 * 对象转字符串
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ObjectDump{
	/**
	 * 把对象格式化为字符串
	 * 
	 * @param mixed/object/array $var
	 * @return string
	 */
	public static function toString($var){
		if(is_object($var)){
			//#obj
			if($var instanceof \Closure){
				//#闭包函数反射
				$refFun   =new \ReflectionFunction($var);
				$closureName=$refFun->getName();
				$startLine  =$refFun->getStartLine();
				if($refFun->getClosureThis()!==null){
					$className=get_class($refFun->getClosureThis());
					return "Closure({$className}:{$startLine})";
				}else{
					$fileName=$refFun->getFileName();
					$fileName=FileName::sub($fileName,50);
					return "Closure({$fileName}:{$startLine})";
				}
			}
			return "Object(".get_class($var).")";
			
		}elseif(is_array($var)){
			//#array
			return "Array(".json_encode($var,JSON_UNESCAPED_UNICODE).")";
		}elseif(is_bool($var)){
			//#bool
			if($var){
				return 'Boolean(true)';
			}else{
				return 'Boolean(false)';
			}
		}else{
			//#string
			//return "String(".(string)$var.")";
			return '"'.(string)$var.'"';
		}
	}
}
?>
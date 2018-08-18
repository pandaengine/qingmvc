<?php
namespace qing\exception;
/**
 * 异常信息格式化
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class DebugFormatter{
	/**
	 * 格式化异常信息
	 * @param \Exception $exception
	 */
	public static function format(\Exception $exception){
		$message=$exception->getMessage();
		$message=htmlentities($message);
		if(method_exists($exception,'getTitle')){
			$message=$exception->getTitle().$message;
		}
		//
		$data=array();
		$data['class'] 		=get_class($exception);
		$data['errorCode'] 	=self::getErrorCode($exception->getCode());
		$data['message'] 	=$message;
		//$data['position']	=self::getPosition($exception);
		$data['trace']	 	=self::getTrace($exception);
		$data['envData']	=self::getEnvRequestData();
		return $data;
	}
	/**
	 * 获取追踪信息
	 */
	protected static function getTrace(\Exception $exception){
		//#异常追踪信息
		$trace=$exception->getTrace();
		$i=count($trace);
		
		$traceInfo=array();
		//将异常抛出位置添加到trace信息
		$traceInfo[$i]=self::getPosition($exception);
		$i--;
		foreach($trace as $t){
			$traceRow=$t;
			//函数操作
			$traceRow['action']		=@$t['class'].@$t['type'].@$t['function'];
			//字符串参数
			if(!empty($t['args'])){
				$argsString=array_map(array(__CLASS__,'objToString'),(array)$t['args']);
				$argsString='('.implode(',', $argsString).')';
			}else{
				$argsString='';
			}
			$traceRow['argsString']=$argsString;
			//代码
			$traceRow['code']	   =self::getCode(@$t['file'],@$t['line']);
			$traceRow['filename']  =self::formatFileName(@$t['file']);
			
			$traceInfo[$i]=$traceRow;
			$i--;
		}
		return $traceInfo;
	}
	/**
	 * 取得代码
	 * 
	 * @param string $file
	 * @param number $lineNum
	 * @return array
	 */
	protected static function getCode($file,$lineNum){
		$codes=array();
		if(!is_file($file)){
			return $codes;
		}
		//file()将文件作为一个数组返回。数组中的每个单元都是文件中相应的一行，包括换行符在内。
		$lineArray=file($file);
		//lines键值从0开始|键值是行数减1
		$lines=array_slice($lineArray,$lineNum-5,10,true);
		
		//$codes['lineNum']=$lineNum;
		foreach ($lines as $line=>$value){
			//$codes['lines'][$line+1]=$value;
			$codes[$line+1]=$value;
		}
		return $codes;
	}
	/**
	 * 获取异常抛出位置
	 */
	protected static function getPosition(\Exception $exception){
		//#抛出异常的位置
		$line=array();
		//抛出错误的文件|位置
		$line['file']=$exception->getFile();
		$line['filename']=self::formatFileName($line['file']);
		//抛出错误的行
		$line['line']=$exception->getLine();
		$line['code']=self::getCode($line['file'],$line['line']);
		return $line;
	}
	/**
	 * 格式化文件名
	 * 截取文件名称
	 *
	 * @param string $filename
	 */
	protected static function formatFileName($filename){
		$ds=DS;
		$ds=preg_quote($ds,'/');
		$match=preg_match('/^(.*)'.$ds.'.{26,}$/i',$filename,$matchs);
		if(!(bool)$match){
			return $filename;
		}
		$filename=substr($filename,strlen($matchs[1]));
		return '...'.$filename;
		//前瞻断言,正面断言： \w+(?=;) 匹配一个单词紧跟着一个分号但是匹配结果不会包含分号，
		//$filename=preg_replace('/^(.*)(?=\\\\.{50,})/i','',$filename);
		//return '...'.$filename;
		//return substr($filename,-50);
	}
	/**
	 * - 过滤字符串
	 * - 递归处理
	 * 
	 * @param string $var
	 */
	protected static function safeString($var){
		if(is_array($var)){
			$var=array_map(function($value){
				return self::safeString($value);
			},$var);
			return $var;
		}
		if(is_string($var)){
			return htmlentities($var);
		}else{
			return $var;
		}
	}
	/**
	 * 对象格式化为字符串
	 * 
	 * @see obj2string
	 * @param array|object $var
	 * @return string
	 */
	public static function objToString($var){
		if(is_object($var)){
			//$var="Object(".get_class($var).")";
			$var=var_export($var,true);
			$var=str_replace('::__set_state','',$var);
			return "Object({$var})";
		}elseif(is_array($var)){
			$var=self::safeString($var);
			$var=json_encode($var,JSON_UNESCAPED_UNICODE);
			$var=htmlentities($var);
			return "Array({$var})";
		}elseif(is_bool($var)){
			if($var){
				return 'true';
			}else{
				return 'false';
			}
		}else{
			$var=self::safeString($var);
			$var=htmlentities($var);
			return "String(\"{$var}\")";
		}
	}
	/**
	 * 获取环境和用户数据
	 */
	public static function getEnvRequestData(){
		$datas=array(
				"[ GET ]"       => (array)$_GET,
				"[ POST ]"      => (array)$_POST,
				"[ FILES ]"     => (array)$_FILES,
				"[ COOKIE ]"    => (array)$_COOKIE,
				"[ SESSION ]"   => (array)$_SESSION,
				"[ SERVER  ]"   => (array)$_SERVER,
		);
		return $datas;
	}
	/**
	 * 错误代码
	 * @param int $errorCode 错误code
	 * @return string
	 */
	public static function getErrorCode($errorCode){
		//取得已定义的常量|并分类true
		$constants = get_defined_constants(true);
		if(isset($constants['Core'])){
			foreach ($constants['Core'] as $constant =>$value) {
				if(substr($constant,0,2)=='E_' && $value==$errorCode){
					return $constant;
				}
			}
		}
		return "E_UNKNOWN";
	}
}
?>
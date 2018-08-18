<?php 
namespace qing\lang;
/**
 * 编译器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class TipCompiler{
	/**
	 * 编译语言
	 * 
	 * @param array $langs
	 * @return string
	 */
	public static function compile(array $langs){
		$content  = "<?php\n";
		$content .= "exit('do not use it! only for tip! '.__FILE__);\n";
		$content .= "class L extends \\qing\\lang\\L{\n";
		$content .= self::buildMethods($langs);
		$content .= "}\n?>";
		return $content;
	}
	/**
	 *
	 * @param array  $datas
	 */
	protected static function buildMethods(array $langs){
		$content='';
		foreach($langs as $key=>$value){
			$key  =self::getLangKey($key);
			$value=self::getLangValue((string)$value);
			if($key>''){
				//#成员函数
				$parems=self::getMethodParams($value);
				$content .= " \t public static function {$key}({$parems}){ return '{$value}'; }\n";
			}
		}
		return $content;
	}
	/**
	 * 格式化过滤属性名称
	 *
	 * @param string $key
	 */
	protected static function getLangKey($key){
		//只允许字母数字下划线
		$key=preg_replace('/[^a-zA-Z0-9\_]/','',$key);
		//首字母只能是字母或下划线
		if(!preg_match('/^[a-z\_]/i', $key)){
			return '';
		}
		return $key;
	}
	/**
	 * 格式化过滤属性值
	 *
	 * @uses addslashes
	 * @param string $value
	 */
	protected static function getLangValue($value){
		$arr=array(
			//转义单引号
			'\''=>'\\\'',
			//转义符号
			'\\'=>'\\\\',
		);
		/*@see qreplace()  */
		return strtr($value,$arr);
	}
	/**
	 * 获取函数参数
	 * 
	 * @param string $value
	 */
	protected static function getMethodParams($value){
		$res=preg_match_all('/%([a-z])/i',$value,$matches);
		if($res>0){
			$matches=$matches[1];
			return '$'.implode(',$',$matches);
		}else{
			return '';
		}
	}
}
?>
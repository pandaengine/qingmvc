<?php
namespace qing\forms;
use qing\tips\Utils;
/**
 * 字段过滤器
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class FilterBuilder{
	/**
	 *
	 * @var array
	 */
	public $types=[];
	/**
	 *
	 * @var array
	 */
	public $comments=[];
	/**
	 * 
	 * @param array  $fields
	 * @param string $className
	 * @param string $namespace
	 */
	public function build(array $fields,$className,$namespace=''){
		$namespace=trim($namespace,'\\');
		$className=Utils::getClassName($className);
		$theme=
		"<?php\n{namespace}\n".
		"/**\n *\n *\n */\n".
		'class {class} extends \qing\forms\Form{'."\n".
		'{filter}'.
		'{methods}'.
		'}'."\n".
		'?>';
		$vars=[];
		$vars['{namespace}']	=Utils::getNamespace($namespace);
		$vars['{class}']		='_'.$className;
		$vars['{filter}']		=$this->getFilter($fields);
		$vars['{methods}']		=$this->getMethods($fields);
		/*@see qreplace */
		$content=strtr($theme,$vars);
		return $content;
	}
	/**
	 * @param array $types
	 * @return $this
	 */
	public function types(array $types){
		$this->types=$types;
		return $this;
	}
	/**
	 * @param array $comments
	 * @return $this
	 */
	public function comments(array $comments){
		$this->comments=$comments;
		return $this;
	}
	/**
	 *
	 * @param array $fieldName
	 * @return $this
	 */
	protected function getType($fieldName){
		if(!$this->types || !isset($this->types[$fieldName])){
			return 'string';
		}
		return $this->types[$fieldName];
	}
	/**
	 *
	 * @param array $fieldName
	 * @return $this
	 */
	protected function getComment($fieldName){
		return (string)$this->comments[$fieldName];
	}
	/**
	 *
	 * @param array $fields
	 */
	protected function getFilter(array $fields){
		$inner="\t\t\$row=[];\n";
		foreach($fields as $field){
			$type=$this->getType($field);
			$get =Utils::getMethodName($field,'get');
			
			$inner.="\t\t\$row['{$field}']=\$this->{$get}(\$data['{$field}']);\n";
		}
		$code=
		"\t/**\n\t * @return array \n\t */\n".
		"\tpublic function filter(array \$data){\n".
		"{$inner}".
		"\t\treturn \$row;\n".
		"\t}\n";
		return $code;
	}
	/**
	 * 遍历各个属性
	 *
	 * @param array $fields
	 */
	protected function getMethods(array $fields){
		$content='';
		foreach($fields as $field){
			$content.=$this->getGetMethod($field);
		}
		return $content;
	}
	/**
	 * @param string $field
	 */
	protected function getGetMethod($field){
		$type=$this->getType($field);
		$comm=$this->getComment($field);
		$comm=='' && $comm=$field;
		
		$theme="\t/**\n".
		"\t * {$comm} \n\t * \n".
		"\t * @param {$type} ".'${method}'."\n\t */\n".
		"\tpublic function {methodName}(\${method}){\n".
		"\t\t\${method}=({$type})\${method};\n".
		"\t\treturn \${method};\n".
		"\t}\n";
	
		$vars=[];
		$vars['{method}'] 		=$field;
		$vars['{methodName}'] 	=Utils::getMethodName($field,'get');
		/*@see qreplace */
		$content=strtr($theme,$vars);
		return $content;
	}
}
?>
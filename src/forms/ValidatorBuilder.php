<?php
namespace qing\forms;
use qing\tips\Utils;
/**
 * 字段
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ValidatorBuilder{
	/**
	 * 是否生成set/get方法
	 *
	 * @var boolean
	 */
	public $setOn=true;
	/**
	 * 是否生成set/get方法
	 *
	 * @var boolean
	 */
	public $getOn=true;
	/**
	 *
	 * @var boolean
	 */
	public $createOn=true;
	/**
	 * 属性注释
	 * 
	 * @var boolean
	 */
	public $propComment=true;
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
	 * @return string
	 */
	public function __construct(){
		
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
		'{fieldsArr}'.
		'{fields}'.
		'{datas}'.
		'{props}'.
		'{construct}'.
		'{createRow}'.
		'{createSet}'.
		'{create}'.
		'{validate}'.
		'{getRow}'.
		'{methods}'.
		'}'."\n".
		'?>';
		$vars=[];
		$vars['{namespace}']	=Utils::getNamespace($namespace);
		$vars['{class}']		='_'.$className;
		$vars['{fieldsArr}']	=$this->getFieldsArr($fields);
		$vars['{datas}']		=$this->getDatas($fields);
		$vars['{fields}']		=$this->getFieldsStr($fields);
		$vars['{props}']		=$this->getPropertys($fields);
		$vars['{construct}']	=$this->getConstruct($fields);
		$vars['{createRow}']	=$this->getCreateRow($fields);
		$vars['{createSet}']	=$this->getCreateSet($fields);
		$vars['{create}']		=$this->getCreate($fields);
		$vars['{validate}']		=$this->getValidate($fields);
		$vars['{getRow}']		=$this->getGetRow($fields);
		$vars['{methods}']		=$this->getMethods($fields);
		/*@see qreplace */
		$content=strtr($theme,$vars);
		return $content;
	}
	/**
	 *
	 * @param array $fields
	 */
	protected function getCreate(array $fields){
		$inner="";
		foreach($fields as $field){
			$type=$this->getType($field);
			$inner.="\t\t\$this->{$field}=({$type})\$row['{$field}']; \n";
		}
		$code=
		"\t/**\n\t * @param array \$row \n\t */\n".
		"\tpublic function create(array \$row){\n".
		"{$inner}".
		"\t}\n";
		return $code;
	}
	/**
	 * 创建合法的字段数据行
	 * 
	 * @param array $fields
	 */
	protected function getCreateRow(array $fields){
		$inner="\t\t\$row=[];\n";
		foreach($fields as $field){
			$type=$this->getType($field);
			$inner.="\t\t\$row['{$field}']=({$type})\$data['{$field}']; \n";
		}
		$code=
		"\t/**\n".
		"\t * 创建合法的字段数据行\n\t * \n".
		"\t * @param array \$data \n\t */\n".
		"\tpublic function createRow(array \$data){\n".
		"{$inner}".
		"\t\treturn \$row;\n".
		"\t}\n";
		return $code;
	}
	/**
	 * 创建合法的字段数据行
	 *
	 * @param array $fields
	 */
	protected function getCreateSet(array $fields){
		$inner="";
		foreach($fields as $field){
			$type=$this->getType($field);
			$set =Utils::getMethodName($field,'set');
			$inner.="\t\t\$this->{$set}(({$type})\$row['{$field}']); \n";
		}
		$code=
		"\t/**\n".
		"\t * 自动使用set方法 \n\t * \n".
		"\t * @param array \$row \n\t */\n".
		"\tpublic function createSet(array \$row){\n".
		"{$inner}".
		"\t\treturn \$row;\n".
		"\t}\n";
		return $code;
	}
	/**
	 *
	 * @param array $fields
	 */
	protected function getGetRow(array $fields){
		$inner="\t\t\$row=[];\n";
		foreach($fields as $field){
			$type=$this->getType($field);
			$inner.="\t\t\$row['{$field}']=\$this->{$field};\n";
		}
		$code=
		"\t/**\n\t * @return array \n\t */\n".
		"\tpublic function getRow(){\n".
		"{$inner}".
		"\t\treturn \$row;\n".
		"\t}\n";
		return $code;
	}
	/**
	 * 遍历各个属性
	 * $propValue=var_export($fields,true);
	 *
	 * @param array $fields
	 */
	protected function getFieldsArr(array $fields){
		$values=[];
		foreach($fields as $field){
			$values[]="'{$field}'";
		}
		$values ='['.implode(',',$values).']';
		$content="\tpublic \$fieldsArr={$values};\n";
		return $content;
	}
	/**
	 * 遍历各个属性
	 *
	 * @param array $fields
	 */
	protected function getFieldsStr(array $fields){
		$values =implode(',',$fields);
		$content="\tpublic \$fields='{$values}';\n";
		return $content;
	}
	/**
	 * 遍历各个属性
	 *
	 * @param array $fields
	 */
	protected function getPropertys(array $fields){
		$content='';
		foreach($fields as $field){
			$prop=Utils::getPropName($field);
			$type=$this->getType($field);
			$comm=$this->getComment($field);
			$comm=='' && $comm=$field;
			
			$content.="\t/**\n";
			$content.="\t * {$comm} \n\t * \n";
			$content.="\t * @var {$type} \n\t */\n";
			$content.="\tpublic $".$prop."='';\n";
		}
		return $content;
	}
	/**
	 * 数据缓存
	 *
	 * @param array $fields
	 */
	protected function getDatas(array $fields){
		$content='';
		$content.="\t/**\n";
		$content.="\t * 所有字段数据 \n\t * \n";
		$content.="\t * @var array \n\t */\n";
		$content.="\tprotected \$_data=[];\n";
		return $content;
	}
	/**
	 * 获取构造函数
	 *
	 * @param array $fields
	 */
	protected function getConstruct(array $fields){
		$code=
		"\t/**\n".
		"\t * 构造函数，注入数据 \n\t * \n".
		"\t * @param array \$data \n\t */\n".
		"\tpublic function __construct(array \$data){\n".
		"\t\t\$this->_data=\$data;\n".
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
			if($this->getOn){
				$content.=$this->getGetMethod($field);
			}
			if($this->setOn){
				$content.=$this->getSetMethod($field);
			}
		}
		return $content;
	}
	/**
	 * @param string $field
	 */
	protected function getSetMethod($field){
		$type=$this->getType($field);
		$theme=
		"\t/**\n\t * @param {$type} ".'${method}'."\n\t */\n".
		"\tpublic function {methodName}(\${method}){\n".
		"\t\t\$this->{method}=({$type})\${method};\n".
		"\t\treturn true;\n".
		"\t}\n";
		
		$vars=[];
		$vars['{method}'] 		=$field;
		$vars['{methodName}'] 	=Utils::getMethodName($field,'set');
		/*@see qreplace */
		$content=strtr($theme,$vars);
		return $content;
	}
	/**
	 * @param string $field
	 */
	protected function getGetMethod($field){
		$type=$this->getType($field);
		$theme=
		"\t/**\n\t * @return {$type}\n\t */\n".
		"\tpublic function {methodName}(){\n".
		"\t\treturn ".'$this->{method}'.";\n".
		"\t}\n";
		
		$vars=[];
		$vars['{method}'] 		=$field;
		$vars['{methodName}'] 	=Utils::getMethodName($field,'get');
		/*@see qreplace */
		$content=strtr($theme,$vars);
		return $content;
	}
	/**
	 * 验证字段数据
	 * #validate/setField/getRow完成数据验证过滤和获取的一条龙服务
	 * 
	 * @param array $fields
	 */
	protected function getValidate(array $fields){
		$condition="";
		foreach($fields as $field){
			$type=$this->getType($field);
			$set =Utils::getMethodName($field,'set');
			if($condition>''){
				$condition.="\n\t\t && ";
			}
			//$condition.="\$this->{$set}(({$type})\$row['{$field}'])";
			$condition.="\$this->{$set}(\$row['{$field}'])";
		}
		$code=
		"\t/**\n".
		"\t * validate/setField/getRow完成数据验证过滤和获取的一条龙服务 \n\t * \n".
		"\t * @param array \$row \n\t */\n".
		"\tpublic function validate(array \$row){\n".
		"\t\t\$res={$condition};\n".
		"\t\treturn \$res;\n".
		"\t}\n";
		return $code;
	}
}
?>
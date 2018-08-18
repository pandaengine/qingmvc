<?php
namespace qing\adapter;
use qing\com\Component;
use qing\exceptions\http\NotFoundHttpException;
/**
 * 控制器适配器
 * 不解析操作参数
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class ControllerAdapter extends Component implements AdapterInterface{
	/**
	 * 当前模块
	 *
	 * @var \qing\app\Module
	 */
	public $module;
	/**
	 * 禁止访问的操作名称
	 * 
	 * - beforeaction可能会被不小心写成public访问权限，如果是protected则没有风险
	 * - 基类的Component::initComponent也可能被作为控制器操作访问
	 * 
	 * @var array 必须小写
	 */
	public $banActionNames=['beforeaction','afteraction'];
	/**
	 * @var \ReflectionMethod
	 */
	protected $__refMethod;
	/**
	 * 使用适配器执行处理器
	 *
	 * @param \qing\router\RouteBag $routeBag
	 */
	public function run(\qing\router\RouteBag $routeBag){
		$module=mod();
		if($routeBag->className){
			//路由自定义控制器类
			$ctrlClass=$routeBag->className;
		}else{
			//自动寻找控制器类
			$ctrlClass=$module->getCtrlName($routeBag->ctrl);
		}
		//#创建控制器
		$ctrl=$module->getController($ctrlClass);
		if(!$ctrl){
			//#找不到控制器|错误控制器不可访问
			throw new NotFoundHttpException(L()->ctrl_notfound.':'.$routeBag->ctrl);
		}
		//#格式化操作名
		$actionName=$module->getActionName($routeBag->action);
		//#安全检查
		$error='';
		$res=$this->runSecurity($ctrl,$actionName,$error);
		if($res===false){
			$error>'' && $error=' ( '.$error.' ) ';
			throw new NotFoundHttpException(L()->http_notfound404.$error.$routeBag->ctrl.'->'.$routeBag->action);
		}
		//执行操作
		return $this->runAction($ctrl,$routeBag->ctrl,$actionName,(array)$routeBag->params);
	}
	/**
	 * 执行指定操作
	 * 不解析操作参数
	 *
	 * @param \qing\controller\Controller $ctrl
	 * @param string $ctrlName
	 * @param string $actionName 操作名称
	 * @return mixed
	 */
	protected function runAction($ctrl,$ctrlName,$actionName){
		return $ctrl->_runAction($ctrlName,$actionName);
	}
	/**
	 * 控制器执行安全
	 * 访问权限控制
	 * 禁止系统函数的访问
	 *
	 * @param \qing\controller\Controller $ctrl
	 * @param string $actionName
	 * @throws \qing\exceptions\http\NotFoundHttpException
	 */
	protected function runSecurity($ctrl,$actionName,&$error=''){
		//#访问权限
		if(!$ctrl->httpAccess){
			//#限制http访问
			$error=L()->ctrl_forbidden;
			return false;
		}
		if(!method_exists($ctrl,$actionName)){
			//#操作方法不存在
			$error=L()->action_notfound;
			return false;
		}
		//#取得对象的方法的反射对象
		$refMethod=$this->__refMethod=new \ReflectionMethod($ctrl,$actionName);
		//#非public方法或静态方法禁止访问
		if(!$refMethod->isPublic() || $refMethod->isStatic()){
			$error='非公开或静态';
			return false;
		}
		//#以下划线开头禁止访问/_runAction()/__construct等系统内置函数
		if(substr($actionName,0,1)==='_'){
			$error='操作名不能以下划线开头';
			return false;
		}
		//#禁止访问的操作名称，或控制器名称
		if($this->banActionNames && in_array(strtolower($actionName),$this->banActionNames) ){
			$error='禁用的操作方法/控制器类';
			return false;
		}
		return true;
		/*
		//$refMethod->class : 当前（操作方法）所在的类，可能是当前类或者父类
		//get_class($this) : 当前类
		$methodClass=$refMethod->class;
		//#禁止访问控制器父类的成员函数
		if($methodClass!=get_class($ctrl)){
			//用户控制器不要多级继承，使用trait来扩展操作方法
			$error='禁止访问控制器父类的成员函数';
			return false;
		}
		return true;
		*/
	}
}
?>
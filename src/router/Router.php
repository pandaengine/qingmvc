<?php 
namespace qing\router;
use qing\com\Component;
use qing\exceptions\http\IllegalRouteException;
/**
 * 基础路由器
 *  
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class Router extends Component{
	/**
	 * 默认路由
	 * 主页路由
	 * 默认的控制器，操作或模块
	 * ['index','index']
	 * ['user','index','index']
	 * 
	 * @name def index home
	 * @var string
	 */
	public $index=['index','index'];
	/**
	 * 解析处理器
	 *
	 * @var array
	 */
	protected $parsers=[];
	/**
	 * 接管路由
	 *
	 * @name $ROUTE $routeBag
	 * @var RouteBag
	 */
	protected $_takeover;
	/**
	 * 路由解析
	 * 
	 * @return \qing\router\RouteBag
	 */
	public function parse(){
		if($this->_takeover){
			//已经解析直接返回
			return $this->_takeover;
		}
		//#使用解析器链解析路由
		$routeBag=$this->runParsers();
		if($routeBag){
			//#路由安全验证
			if(!self::validateRoute($routeBag)){
				throw new IllegalRouteException();
				return false;
			}
		}
		return $routeBag;
	}
	/**
	 * 匹配路由链
	 * get->routes->pathinfo
	 *
	 * @name match
	 * @return \qing\router\RouteBag
	 */
	protected function runParsers(){
		foreach($this->parsers as $key=>$parser){
			/*@var $parser \qing\router\parserInterface */
			$routeBag=$parser->parse();
			//false/继续下一个解析器
			if($routeBag!==false){
				//不为false
				if(is_int($routeBag) && $routeBag==ParserInterface::INDEX){
					//使用默认路由
					return $this->getIndex();
				}else{
					//找到路由则返回
					return $routeBag;
				}
			}
		}
		return false;
	}
	/**
	 * 获取默认路由
	 *
	 * @return RouteBag
	 */
	public function getIndex(){
		return Utils::toBag(Utils::format($this->index));
	}
	/**
	 * 接管路由
	 *
	 * @param mixed $route
	 */
	public function takeover($route){
		$this->_takeover=$route;
	}
	/**
	 * 添加路由解析器/到尾部
	 * push pop shift unshift
	 *
	 * @param ParserInterface $parser
	 * @return $this
	 */
	public function pushParser(ParserInterface $parser){
		//追加到尾部
		array_push($this->parsers,$parser);
		return $this;
	}
	/**
	 * 添加路由解析器/到头部
	 * 在数组开头插入一个或多个元素。
	 *
	 * @param ParserInterface $parser
	 * @return $this
	 */
	public function unshiftParser(ParserInterface $parser){
		//插入头部
		array_unshift($this->parsers,$parser);
		return $this;
	}
	/**
	 * 验证路由安全
	 * 只允许字母数字下划线
	 *
	 * @param RouteBag $routeBag
	 */
	static public function validateRoute(RouteBag $routeBag){
		$validator=function($value){
			return preg_match('/[^a-zA-Z0-9\_]/',$value)==0;//排除法，不允许非法字符
		};
		if(!$validator($routeBag->module)){
			return false;
		}
		if(!$validator($routeBag->ctrl)){
			return false;
		}
		if(!$validator($routeBag->action)){
			return false;
		}
		return true;
	}
}
?>
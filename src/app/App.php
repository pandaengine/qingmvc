<?php 
namespace qing\app;
use qing\Qing;
use qing\com\Component;
use qing\com\Coms;
use qing\autoload\AutoLoad;
use qing\autoload\AliasLoader;
use qing\config\AppConfig;
use qing\exceptions\NotfoundFileException;
use qing\exceptions\NotfoundItem;
use qing\exceptions\NotfoundDirException;
use qing\utils\Instance;
/**
 * 应用基类
 * 应用上下文应该是很容易取得上下文数据的/包括组件等等
 * 应用未初始化，不设置事件点
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class App extends Component implements AppInterface{
	/**
	 * 模块支持
	 */
	use traits\ModuleTrait;
	/**
	 * 应用是否完成初始化
	 *
	 * @var boolean
	 */
	public static $inited=false;
	/**
	 * 
	 * @var boolean
	 */
	public static $inited_finished=false;
	/**
	 * 应用运行入口|开始事件|begin/before/post/after/end
	 *
	 * @var string
	 */
	const E_APP_BEGIN='app.begin';
	/**
	 * 应用名称
	 * 
	 * #只有主模块接管http
	 * #其他模块，例如：uid_client
	 * 
	 * @var string
	 */
	public $appName='app';
	/**
	 * 应用环境
	 * 
	 * local 本地调试环境 
	 * main 主配置环境
	 * 
	 * @notice 可以指定环境，为空时，不使用任何环境，使用默认主配置
	 * @var string
	 */
	public $environment;
	/**
	 * 应用的命名空间
	 * 主模块命名空间
	 *
	 * @var string
	 */
	public $namespace;
	/**
	 * 应用路径
	 *
	 * @var string
	 */
	public $basePath;
	/**
	 * 应用配置目录
	 *
	 * @var string
	 */
	public $configPath;
	/**
	 * 应用执行缓存目录
	 *
	 * @var string
	 */
	public $runtimePath;
	/**
	 * 应用所处的时区
	 * 必须
	 * 
	 * @var string
	 */
	public $timezone="PRC";
	/**
	 * 执行应用
	 * 启动应用
	 */
	public function run(){
		
	}
	/**
	 * 初始化应用环境
	 * 初始化应用上下文
	 * 
	 * 注意：在应用未初始化完毕就抛出异常
	 * - 字符串：
	 * - 数组：必须包含configPath
	 * 
	 * APP_CONFIG
	 * APP_PATH
	 * APP_RUNTIME
	 * 
	 * @param string/array $configFile 应用配置文件
	 */
	public function __construct($configFile){
		if(self::$inited){
			//应用只能被创建一次
			throw new \Exception("应用只能被创建一次");
		}
		self::$inited=true;
		//#主应用|保存当前应用上下文实例,对象都是引用传递的
		Qing::setApp($this);
		//#初始化框架环境/QING_PATH未定义
		require_once __DIR__.'/../init.php';
		//#载入公共函数库
		require_once QING_FUNCTION.DS.'function.php';
		//
		if(!is_file($configFile)){
			throw new NotfoundFileException('应用配置文件,'.$configFile);
		}
		$this->configPath=dirname($configFile);
		define('APP_CONFIG',$this->configPath);
		//初始化配置信息 
		$configs=AppConfig::get($configFile);
		//
		$this->initPath($configs);
		//初始化组件系统
		$this->initComs($configs);
		//注入属性
		Instance::setProps($this,$configs);
		date_default_timezone_set($this->timezone);
		//设置默认主模块
		$this->initMainModule();
		//#应用初始化完成/在组件中判断应用是否已经初始化完毕
		self::$inited_finished=true;
	}
	/**
	 * 初始化应用
	 * 
	 * @param array $configs
	 */
	protected function initPath(array &$configs){
		//#应用根目录
		if(!isset($configs['basePath'])){
			throw new NotfoundItem('basePath');
		}
		$path=$configs['basePath'];
		unset($configs['basePath']);
		if(!is_dir($path)){
			throw new NotfoundDirException($path);
		}
		$this->basePath=$path;
		define('APP_PATH',$path);
		//#命名空间
		if(isset($configs['namespace'])){
			$this->namespace=$configs['namespace'];
			//#导入应用命名空间和路径映射
			AutoLoad::addNamespace($this->namespace,$this->basePath);
			unset($configs['namespace']);
		}
		define('APP_NAMESPACE',$this->namespace);
		//#应用执行缓存目录
		if(isset($configs['runtimePath'])){
			$this->runtimePath=$configs['runtimePath'];
			unset($configs['runtimePath']);
		}else{
			//默认
			$this->runtimePath=$this->basePath.DS.DKEY_RUNTIME;
		}
		define('APP_RUNTIME',$this->runtimePath);
	}
	/**
	 * 初始化组件
	 * - 需要先创建组件管理器
	 * - 才能注入模块、拦截器数据，它们都是组件实现的
	 * 
	 * @param array $configs
	 */
	protected function initComs(array &$configs){
		//#初始化组件管理器
		$coms=Qing::$coms=new Coms();
		//#注册框架必备的基础核心组件
		$_coms=(array)require QING_CONFIG.DS."coms.php";
		//#注入组件配置
		if(isset($configs['components'])){
			//递归替换子选项/array_merge
			$_coms=array_replace_recursive($_coms,$configs['components']);
			unset($configs['components']);
		}
		//覆盖所以配置
		$coms->setServices($_coms);
	}
	/**
	 * 类别名
	 * 注意：先注册文件加载器autoload，再注册别名autoload
	 * 
	 * @param array $list
	 */
	public function setAliases(array $list){
		AliasLoader::sgt()->addAliases($list);
	}
	/**
	 * 类自动加载器
	 *
	 * @param array $list
	 */
	public function setNamespaces(array $list){
		AutoLoad::addNamespaces($list);
	}
	/**
	 * 用户配置信息
	 * 可以使用常量/注入应用额外配置信息
	 *
	 * @see \qing\config\Config
	 * @param array/string $configs
	 */
	public function setConfigs($configs){
		Qing::$coms->set('config',['configs'=>$configs]);
	}
}
?>
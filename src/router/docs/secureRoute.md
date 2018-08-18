
 * 路由取得的是用户输入的数据，危险数据
 * 【"';:/\】 encodeURI(a);  【%22';:/%5C】
 * module/ctrl/action均只允许字母、数字、下划线、减号
 * --------------------------------------------------
 * 1.模块名称:
 * 危险系数低
 * --------------------------------------------------
 * 2.控制器：危险系数高 !important
 * class_exists($controllerClass)
 * autoload(); is_file、include file 检测类文件是否存在；
 * /index.php/Post/../index-id-1 ctrl=Post/../index 可能定位到其他的类文件
 *
 * index.php/Index/index
 * index.php/Index../index
 * index.php/Index..\\a\\a/index
 * --------------------------------------------------
 * 3.操作：
 *  危险系数低，不过还是过滤 : method_exists(ctrl,$actionName) ;
 * 	$actionName='index-2'/';;:::dssd'/'-=9%^'
 * --------------------------------------------------
 * 4.其他参数：
 * 在输入时需要主动过滤或验证
 *
 * TODO::所有用户输入数据都是不安全的，都不能直接输出|避免(ROUTE_CTRL)常量XSS
 *
 * @param RouteBag $routeBag

protected function secureRoute($routeBag){
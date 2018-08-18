
@links
E:\WEB-INF\QingPHP2015v2\qingmvc\vendor\qingmvc\qlogger2016

#filter

-不同处理器处理不同等级的日志
-错误日志使用邮件发送至管理员邮箱

$handler01=new \qlogger\handler\FileHandler();
$handler01->setLevel(Logger::ERROR);
$handler01->saveDirRule 	='123';
$handler01->saveNameRule	='handler01';
$handler01->levelNameDepart	=true;

$handler02=new \qlogger\handler\FileHandler();
$handler02->setLevel(Logger::INFO);
$handler02->saveDirRule 	='abc';
$handler02->saveNameRule	='handler02';
$handler02->levelNameDepart	=true;
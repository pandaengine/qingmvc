<?php
namespace qing\exceptions\http;
use qing\exceptions\Exception;
/**
 * 自定义Http异常
 * 
 * HTTP错误代码可以通过StatusCode获得。 
 * 错误处理程序可以使用此状态码来决定如何格式化错误页面。
 * 
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
class HttpException extends Exception{
}
?>
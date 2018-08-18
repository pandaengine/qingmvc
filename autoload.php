<?php
use qing\autoload\AutoLoad;
/**
 * qingmvc类自动加载器
 * 如果没有配置composer则可以使用该加载器
 *
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
require_once __DIR__.'/src/autoload/start.php';
AutoLoad::addNamespace('qing',__DIR__.DIRECTORY_SEPARATOR.'src');
?>
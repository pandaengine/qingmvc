<?php
use qing\utils\Url;
use qing\utils\ClassName;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
dump(Url::updateParams(['p'=>'ppp']));
dump(Url::matchHost('http://qingmvc.com/?p=1'));

//
dump(ClassName::format(__CLASS__));
dump(ClassName::onlyNamespace(__CLASS__));
dump(ClassName::onlyName(__CLASS__));

?>
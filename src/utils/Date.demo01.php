<?php
use qing\utils\Date;
/**
 * 
 * @author xiaowang <736523132@qq.com>
 * @copyright Copyright (c) 2013 http://qingmvc.com
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0 all rights reserved.
 */
dump(Date::format(time()));
dump(Date::format(time()-60));
dump(Date::format(time()-2*60));
dump(Date::format(time()-47*60));
dump(Date::format(time()-59*60));
dump(Date::format(time()-2.9*60*60));
dump(Date::format(time()-3*60*60));
dump(Date::format(time()-4*60*60));
dump(Date::format(time()-24*60*60));
dump(Date::format(time()-25*60*60));
dump(Date::format(time()-400*24*60*60));
//
dump(Date::format(strtotime('2018-07-01')));
dump(Date::format(strtotime('2018-01-01')));
dump(Date::format(strtotime('2017-12-31')));
exit();
?>
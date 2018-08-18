<?php
use qing\filesystem\MK;
use qing\filesystem\FileSize;

MK::dir('/data/dir01');

dump(FileSize::format(234));
dump(FileSize::format(150*1024));
dump(FileSize::format(15000*1024*1024));
exit();

dump(FileSize::format(1500*1024,'B'));
dump(FileSize::format(1500*1024,'KB'));
dump(FileSize::format(1500*1024,'mb'));
dump(FileSize::format(1500*1024,'Gb'));
exit();

?>
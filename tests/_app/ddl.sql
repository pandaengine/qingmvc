CREATE TABLE `pre_tests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '网站ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` char(20) NOT NULL DEFAULT '',
  `title` char(50) NOT NULL DEFAULT '' COMMENT '网站名称',
  `num` int(11) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`) COMMENT '名称索引'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站信息表';


CREATE TABLE `pre_tests_myisam` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '网站ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` char(20) NOT NULL DEFAULT '',
  `title` char(50) NOT NULL DEFAULT '' COMMENT '网站名称',
  `num` int(11) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `idx_title` (`title`) COMMENT '名称索引'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站信息表';


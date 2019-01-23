-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nice_name` char(20) DEFAULT NULL COMMENT '昵称',
  `login_name` char(20) DEFAULT NULL COMMENT '登录名',
  `last_time` int(11) DEFAULT '0' COMMENT '最近登录时间',
  `login_pwd` int(11) DEFAULT NULL COMMENT '登录密码',
  `isdel` int(11) DEFAULT '0' COMMENT '{0:正常, 1:删除}',
  `issuper` int(11) DEFAULT '0' COMMENT '{0:普通管理员, 1:超级管理员}',
  PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表';

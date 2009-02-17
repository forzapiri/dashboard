# Module : Analytics
# DB Schema
# 
# Re / Create the Analytics Table.:
#
DROP TABLE IF EXISTS `analytics`;
CREATE TABLE `analytics` (
  `id` int(11) NOT NULL auto_increment,
  `content` text,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#remove module table info and re-insert.:
#
DELETE FROM modules WHERE module = 'Analytics';
INSERT INTO modules VALUES(null ,'Analytics', 'Google Analytics');

#remove permissions and re-create them.:
#
DELETE FROM `permissions` WHERE class = 'Analytics';
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('view','Analytics','View Analytics','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('addedit','Analytics','Add/Edit Analytics','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('delete','Analytics','Delete Analytics','','1','0');
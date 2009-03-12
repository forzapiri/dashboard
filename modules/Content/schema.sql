DROP TABLE IF EXISTS `content_pages`;
CREATE TABLE `content_pages` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL,
  `access` varchar(64) NOT NULL default 'public',
  `url_key` varchar(32) NOT NULL,
  `page_template` varchar(128) default 'site.tpl',
  `page_title` varchar(128) default NULL,
  PRIMARY KEY  (`id`),
  KEY `page_name` (`name`),
  KEY `url_key`(`url_key`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `content_pages` VALUES (1,'Home','2007-12-15 23:23:33',1,'public','home','chunks.tpl','Home');

DROP TABLE IF EXISTS `chunk_revision`;
CREATE TABLE `chunk_revision` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent` int(11) default NULL,
  `content` text,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` enum('active','draft','inactive') default NULL,
  `count` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

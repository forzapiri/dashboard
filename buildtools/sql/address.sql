# CocoaMySQL dump
# Version 0.7b5
# http://cocoamysql.sourceforge.net
#
# Host: localhost (MySQL 5.0.41)
# Database: greenparty
# Generation Time: 2008-10-27 14:33:32 -0400
# ************************************************************

# Dump of table address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `address`;

CREATE TABLE `address` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `street_address` varchar(128) NOT NULL default '',
  `city` varchar(64) NOT NULL default '',
  `postal_code` varchar(16) default NULL,
  `state` int(11) default NULL,
  `country` int(11) default NULL,
  `geocode` varchar(64) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2444 DEFAULT CHARSET=latin1 COMMENT='Generic Address Table';




# Sequel Pro dump
# Version 254
# http://code.google.com/p/sequel-pro
#
# Host: selfdefence (MySQL 5.0.41)
# Database: master
# Generation Time: 2009-02-26 16:06:28 -0400
# ************************************************************

# Dump of table photo_galleries
# ------------------------------------------------------------

CREATE TABLE `photo_galleries` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) default NULL,
  `parent_gallery_id` int(11) default '0',
  `description` text,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` tinyint(1) default '1',
  `thumbnail_id` int(11) default NULL,
  `sort` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;



# Dump of table photo_gallery_images
# ------------------------------------------------------------

CREATE TABLE `photo_gallery_images` (
  `id` int(11) NOT NULL auto_increment,
  `file_id` int(11) default NULL,
  `photo_gallery_id` int(11) default '0',
  `title` varchar(64) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;




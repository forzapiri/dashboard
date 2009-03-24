# Sequel Pro dump
# Version 369
# http://code.google.com/p/sequel-pro
#
# Host: localhost (MySQL 5.0.75)
# Database: qss
# Generation Time: 2009-03-03 15:23:23 -0500
# ************************************************************

# Dump of table calendar
# ------------------------------------------------------------

DROP TABLE IF EXISTS `calendar`;

CREATE TABLE `calendar` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `calendar` (`id`,`name`)
VALUES
	(3,'Example Calendar');



# Dump of table calendar_events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `calendar_events`;

CREATE TABLE `calendar_events` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `event_name` varchar(256) default NULL,
  `event_description` text,
  `event_start` datetime default NULL,
  `event_end` datetime default NULL,
  `event_owner` int(10) unsigned default NULL,
  `event_reminder` varchar(256) default NULL,
  `event_location` varchar(256) default NULL,
  `calendar_id` int(10) unsigned default NULL,
  `status` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `event_owner` (`event_owner`),
  KEY `event_start` (`event_start`),
  KEY `event_end` (`event_end`),
  FULLTEXT KEY `event_description` (`event_description`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

INSERT INTO `calendar_events` (`id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`,`calendar_id`,`status`)
VALUES
	(70,'Test Event','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris adipiscing lacinia mi. Nunc blandit quam eu massa. Suspendisse commodo lacinia nisi. Vestibulum fermentum fermentum magna. Vestibulum arcu erat, pretium a, congue quis, condimentum commodo, nunc. Etiam aliquet. Pellentesque eget quam. Aliquam ut elit vulputate eros feugiat luctus. Aenean faucibus ultricies lacus. Quisque sed orci. Aenean faucibus varius nulla. Vestibulum dignissim dignissim turpis.</p>','2009-02-25 10:02:08','2009-02-25 17:02:08',1,'','',3,0),
	(71,'Another Event','dfgsd sdfg sdgsdfg sfdgsdfg','2009-03-04 00:00:00','2009-03-09 00:00:00',NULL,NULL,'QSS Office',3,0);



# Dump of table calendar_registrants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `calendar_registrants`;

CREATE TABLE `calendar_registrants` (
  `id` int(11) NOT NULL auto_increment,
  `event_id` int(11) default NULL,
  `first_name` varchar(64) default NULL,
  `last_name` varchar(64) default NULL,
  `status` int(11) default NULL,
  `email` varchar(255) default NULL,
  `phone` varchar(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `calendar_registrants` (`id`,`event_id`,`first_name`,`last_name`,`status`,`email`,`phone`)
VALUES
	(1,70,'Chris','Troup',1,'chris@norex.ca','(519) 271-6572');

DELETE FROM `permissions` WHERE class = 'Calendar';
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('addedit','Calendar','Add/Edit Calendars','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('view','Calendar','View Calendars','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('delete','Calendar','Delete Calendars',NULL,'1','1');

DELETE FROM `permissions` WHERE class = 'CalendarEvent';
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('addedit','CalendarEvent','Add/Edit Calendar Events','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('view','CalendarEvent','View Calendar Events','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('delete','CalendarEvent','Delete Calendar Events',NULL,'1','1');


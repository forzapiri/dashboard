# CocoaMySQL dump
# Version 0.7b5
# http://cocoamysql.sourceforge.net
#
# Host: localhost (MySQL 5.0.41)
# Database: brazilieras
# Generation Time: 2008-10-29 13:06:49 -0400
# ************************************************************

# Dump of table calendar_events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `calendar_events`;

CREATE TABLE `calendar_events` (
  `event_id` int(11) NOT NULL auto_increment,
  `event_name` varchar(64) NOT NULL,
  `event_description` text,
  `event_start` datetime NOT NULL,
  `event_end` datetime default NULL,
  `event_owner` int(11) default NULL,
  `event_reminder` enum('yes','no') NOT NULL default 'yes',
  `event_location` text,
  PRIMARY KEY  (`event_id`),
  KEY `event_owner` (`event_owner`),
  KEY `event_start` (`event_start`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('31','dasfsdaf','asdfsadfsadf','2008-07-15 00:00:00',NULL,'1','yes','dfg');
INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('32','Todays Event','this event is for today','2008-07-11 00:00:00',NULL,'1','yes','office');
INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('33','17 is a good number','Lorem ipsum dolar sit amet.','2008-07-17 00:00:00',NULL,'1','yes','');
INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('34','zxcvzxcvzxcv','ZCXvzxcv','2008-07-22 00:00:00',NULL,'1','yes','zxcv');
INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('35','sdfsdf','sdaf','2008-07-15 00:00:00',NULL,'1','yes','sdfsdf');
INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('36','Next Month Event','this event falls on the next month','2008-08-06 00:00:00',NULL,'1','yes','');
INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('37','Better Title','sdfsdf','2008-07-08 00:00:00',NULL,'1','yes','');
INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('38','New Event','this is a new event','2008-07-17 00:00:00',NULL,'1','yes','');
INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('39','Chris Event','this is a description','2008-07-22 00:00:00',NULL,'2505','yes','');
INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('40','dsfg','sdfg','2008-07-25 00:00:00',NULL,'1','yes','');
INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('41','sdfg','sdfg','2008-07-25 00:00:00',NULL,'2506','yes','');
INSERT INTO `calendar_events` (`event_id`,`event_name`,`event_description`,`event_start`,`event_end`,`event_owner`,`event_reminder`,`event_location`) VALUES ('42','dfghfdgh','dfgh','2008-08-08 00:00:00',NULL,'1','yes','');



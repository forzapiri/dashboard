-- MySQL dump 10.11
--
-- Host: localhost    Database: pogue
-- ------------------------------------------------------
-- Server version	5.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `video_galleries`
--

DROP TABLE IF EXISTS `video_galleries`;
CREATE TABLE `video_galleries` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) default NULL,
  `description` tinytext,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) default NULL,
  `description` text,
  `embed_code` text,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` tinyint(1) default '1',
  `video_gallery_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


DELETE FROM `permissions` WHERE class = 'VideoGallery';
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('addedit','VideoGallery','Add/Edit Video Galleries','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('view','VideoGallery','View Video Galleries','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('delete','VideoGallery','Delete Video Galleries',NULL,'1','1');

DELETE FROM `permissions` WHERE class = 'Video';
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('addedit','Video','Add/Edit Gallery Videos','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('view','Video','View Gallery Videos','','1','1');
INSERT INTO `permissions` (`key`,`class`,`name`,`description`,`group_id`,`status`) VALUES ('delete','Video','Delete Gallery Videos',NULL,'1','1');

DELETE from `modules` where `module`="VideoGallery";
INSERT INTO `modules` set `module`="VideoGallery", `display_name`="YouTube Videos";

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-03-25 13:13:14

-- MySQL dump 10.11
--
-- Host: localhost    Database: master
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
-- Table structure for table `chunk`
--

DROP TABLE IF EXISTS `chunk`;
CREATE TABLE `chunk` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` varchar(256) default NULL,
  `role` varchar(256) default NULL,
  `name` varchar(256) default NULL,
  `parent_class` varchar(256) default NULL,
  `parent` int(11) default NULL,
  `active_revision_id` int(10) unsigned default NULL,
  `sort` int(11) default NULL,
  `draft_revision_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk`
--

LOCK TABLES `chunk` WRITE;
/*!40000 ALTER TABLE `chunk` DISABLE KEYS */;
INSERT INTO `chunk` VALUES (28,'textarea',NULL,NULL,'ContentPage',1,54,0,NULL),(29,'textarea',NULL,NULL,'ContentPage',1,55,1,NULL),(30,'textarea',NULL,NULL,'ContentPage',1,56,2,NULL),(31,'text',NULL,NULL,'ContentPage',1,46,3,NULL),(32,'textarea',NULL,NULL,'ContentPage',1,57,4,NULL),(33,'text',NULL,NULL,'ContentPage',1,48,5,NULL),(34,'text',NULL,NULL,'ContentPage',1,49,6,NULL),(35,'tinymce',NULL,NULL,'ContentPage',1,63,7,NULL);
/*!40000 ALTER TABLE `chunk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dbtable`
--

DROP TABLE IF EXISTS `dbtable`;
CREATE TABLE `dbtable` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `table` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `label` varchar(50) NOT NULL,
  `type` varchar(1000) NOT NULL,
  `modifier` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbtable`
--

LOCK TABLES `dbtable` WRITE;
/*!40000 ALTER TABLE `dbtable` DISABLE KEYS */;
INSERT INTO `dbtable` VALUES (1,'press_releases','id','','id','hidden'),(2,'press_releases','title','Title','text',''),(3,'press_releases','content','Content','tinymce',NULL),(4,'press_releases','timestamp','timestamp','timestamp',NULL),(5,'press_releases','status','','status','no form'),(76,'press_releases','enumtest','Fun?','enum(yes,no)',''),(80,'press_releases','owner_id','Owner','User(username)',''),(81,'chunk','id','','id','hidden'),(84,'chunk','type','DBColumn Type','text',''),(99,'chunk_revision','revision','Revision number','integer',''),(87,'chunk','role','Role','text',''),(88,'chunk','name','Name','text',''),(100,'chunk','sort','Sort','sort',''),(90,'chunk','parent_class','Parent Class','text',''),(91,'chunk','parent','Parent ID','integer',''),(93,'chunk','active_revision_id','Active Revision','ChunkRevision',''),(94,'chunk_revision','id','','id','hidden'),(101,'chunk','draft_revision_id','Draft Revision','ChunkRevision',''),(96,'chunk_revision','content','Content','text',''),(97,'chunk_revision','timestamp','Timestamp','timestamp',''),(95,'chunk_revision','parent','Chunk','integer','');
/*!40000 ALTER TABLE `dbtable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chunk_revision`
--

DROP TABLE IF EXISTS `chunk_revision`;
CREATE TABLE `chunk_revision` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent` int(10) unsigned default NULL,
  `content` text,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `revision` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk_revision`
--

LOCK TABLES `chunk_revision` WRITE;
/*!40000 ALTER TABLE `chunk_revision` DISABLE KEYS */;
INSERT INTO `chunk_revision` VALUES (43,28,' Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra v(...)','2009-01-12 17:28:05',0),(44,29,' Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus. Quisque facilisis, ligula ut blandit hendrerit, purus neque rhoncus ipsum, sit amet ultrices ma','2009-01-12 17:28:05',0),(45,30,' Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus. Quisque facilisis, ligula ut blandit hendrerit, purus neque rhoncus ipsum, sit amet ultrices ma','2009-01-12 17:28:05',0),(46,31,'Word of Mouth','2009-01-12 17:28:05',0),(47,32,'Norex has provided us with a website and personal instruction that allows us to maintain our website not only from our offices, but also from remote locations if needed so. Linear is a public company and information distribution such as press releases and ','2009-01-12 17:28:05',0),(48,33,'Terry Christopher, Linear Gold Corp.','2009-01-12 17:28:05',0),(49,34,'Technology','2009-01-12 17:28:05',0),(50,35,'<img src=\"images/widget.jpg\" border=\"0\" alt=\"Olympic Medal Counter\" />\n        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum adipiscing quam. Nulla egestas leo eget ante. In hac habitasse platea dictumst. Class aptent taciti s','2009-01-12 17:28:05',0),(51,35,'<img src=\"/images/widget.jpg\" border=\"0\" alt=\"Olympic Medal Counter\" />\n        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum adipiscing quam. Nulla egestas leo eget ante. In hac habitasse platea dictumst. Class aptent taciti ','2009-01-12 17:29:59',1),(52,28,' Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus. Quisque facilisis, ligula ut blandit hendrerit, purus neque rhoncus ipsum, sit amet ultrices ma','2009-01-12 17:39:04',1),(53,28,' Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus. Quisque facilisis, ligula ut blandit hendrerit, purus neque rhoncus ipsum, sit amet ultrices aj','2009-01-12 17:39:12',2),(54,28,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus. Quisque facilisis, ligula ut blandit hendrerit, purus neque rhoncus ipsum, sit amet ultrices mauris augue non arcu. Donec et sem nec libero viverra accumsan.','2009-01-12 17:41:20',3),(55,29,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus. Quisque facilisis, ligula ut blandit hendrerit, purus neque rhoncus ipsum, sit amet ultrices mauris augue non arcu. Donec et sem nec libero viverra accumsan.','2009-01-12 17:41:20',1),(56,30,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc ligula nisl, egestas non, pharetra vel, scelerisque accumsan, lacus. Proin nibh. Aenean dapibus. Quisque facilisis, ligula ut blandit hendrerit, purus neque rhoncus ipsum, sit amet ultrices mauris augue non arcu. Donec et sem nec libero viverra accumsan.','2009-01-12 17:41:20',1),(57,32,'Norex has provided us with a website and personal instruction that allows us to maintain our website not only from our offices, but also from remote locations if needed so. Linear is a public company and information distribution such as press releases and website...','2009-01-12 17:41:20',1),(58,35,' <img src=\"images/widget.jpg\" border=\"0\" alt=\"Olympic Medal Counter\" />\n        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum adipiscing quam. Nulla egestas leo eget ante. In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur volutpat fringilla elit. Nulla facilisi. <a href=\"#\">Read more &raquo;</a></p>','2009-01-12 17:41:20',2),(59,35,' <img src=\"images/widget.jpg\" border=\"0\" alt=\"Olympic Medal Counter\" />\n        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum adipiscing quam. Nulla egestas leo eget ante. In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur volutpat fringilla elit. Nulla facilisi. <a href=\"#\">Read more Â»</a></p>','2009-01-12 17:41:27',3),(60,35,' <img src=\"images/widget.jpg\" border=\"0\" alt=\"Olympic Medal Counter\" />\n        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum adipiscing quam. Nulla egestas leo eget ante. In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur volutpat fringilla elit. Nulla facilisi. <a href=\"#\">Read more {amp raquo}</a></p>','2009-01-12 17:42:18',4),(61,35,' <img src=\"images/widget.jpg\" border=\"0\" alt=\"Olympic Medal Counter\" />\n        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum adipiscing quam. Nulla egestas leo eget ante. In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur volutpat fringilla elit. Nulla facilisi. <a href=\"#\">Read more &raquot;</a></p>','2009-01-12 17:42:59',5),(62,35,' <img src=\"images/widget.jpg\" border=\"0\" alt=\"Olympic Medal Counter\" />\n        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum adipiscing quam. Nulla egestas leo eget ante. In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur volutpat fringilla elit. Nulla facilisi. <a href=\"#\">Read more...</a></p>','2009-01-12 17:43:35',6),(63,35,' <img src=\"/images/widget.jpg\" border=\"0\" alt=\"Olympic Medal Counter\" />\n        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum adipiscing quam. Nulla egestas leo eget ante. In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur volutpat fringilla elit. Nulla facilisi. <a href=\"#\">Read more...</a></p>','2009-01-12 18:49:00',7);
/*!40000 ALTER TABLE `chunk_revision` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-01-31 16:00:57

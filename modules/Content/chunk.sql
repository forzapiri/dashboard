-- MySQL dump 10.11
--
-- Host: localhost    Database: trunk
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
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbtable`
--

LOCK TABLES `dbtable` WRITE;
/*!40000 ALTER TABLE `dbtable` DISABLE KEYS */;
INSERT INTO `dbtable` VALUES (1,'press_releases','id','','id','hidden'),(2,'press_releases','title','Title','text',''),(3,'press_releases','content','Content','tinymce',NULL),(4,'press_releases','timestamp','timestamp','timestamp',NULL),(5,'press_releases','status','','status','no form'),(76,'press_releases','enumtest','Fun?','enum(yes,no)',''),(80,'press_releases','owner_id','Owner','User(username)',''),(81,'chunk','id','','id','hidden'),(84,'chunk','type','DBColumn Type','text',''),(99,'chunk_revision','revision','Revision number','integer',''),(87,'chunk','role','Role','text',''),(88,'chunk','name','Name','text',''),(100,'chunk','sort','Sort','sort',''),(90,'chunk','parent_class','Parent Class','text',''),(91,'chunk','parent','Parent ID','integer',''),(93,'chunk','active_revision_id','Active Revision','ChunkRevision',''),(94,'chunk_revision','id','','id','hidden'),(101,'chunk','draft_revision_id','Draft Revision','ChunkRevision',''),(96,'chunk_revision','content','Content','text',''),(97,'chunk_revision','timestamp','Timestamp','timestamp',''),(95,'chunk_revision','parent','Chunk','integer','');
/*!40000 ALTER TABLE `dbtable` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk`
--

LOCK TABLES `chunk` WRITE;
/*!40000 ALTER TABLE `chunk` DISABLE KEYS */;
INSERT INTO `chunk` VALUES (1,'text',NULL,NULL,'ContentPageRevision',16,24,NULL,NULL),(2,'tinymce','col1',NULL,'ContentPageRevision',16,25,NULL,NULL),(3,'date',NULL,NULL,'ContentPageRevision',16,26,NULL,NULL);
/*!40000 ALTER TABLE `chunk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chunk_revision`
--

DROP TABLE IF EXISTS `chunk_revision`;
CREATE TABLE `chunk_revision` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent` int(10) unsigned default NULL,
  `content` varchar(256) default NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `revision` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk_revision`
--

LOCK TABLES `chunk_revision` WRITE;
/*!40000 ALTER TABLE `chunk_revision` DISABLE KEYS */;
INSERT INTO `chunk_revision` VALUES (11,1,'Chunk 1a','2009-01-10 10:09:08',1),(12,2,'Chunk 2b','2009-01-10 10:09:08',1),(13,3,'2009-01-06 00:00:00','2009-01-10 10:09:38',1),(21,2,'Chunk 2b revision 2','2009-01-11 16:08:41',2),(20,2,'Chunk 2b rev 1','2009-01-11 16:06:57',2),(22,1,'Chunk 1aaa','2009-01-11 22:44:50',2),(23,2,'Chunk 2b revision 2a','2009-01-11 22:44:50',3),(24,1,'Chunk 1','2009-01-11 22:45:48',3),(25,2,'Chunk 2','2009-01-11 22:45:48',4),(26,3,'2009-01-08 00:00:00','2009-01-11 22:45:48',2);
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

-- Dump completed on 2009-01-11 22:50:46

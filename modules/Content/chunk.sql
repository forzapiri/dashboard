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
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbtable`
--

LOCK TABLES `dbtable` WRITE;
/*!40000 ALTER TABLE `dbtable` DISABLE KEYS */;
INSERT INTO `dbtable` VALUES (1,'press_releases','id','','id','hidden'),(2,'press_releases','title','Title','text',''),(3,'press_releases','content','Content','tinymce',NULL),(4,'press_releases','timestamp','timestamp','timestamp',NULL),(5,'press_releases','status','','status','no form'),(76,'press_releases','enumtest','Fun?','enum(yes,no)',''),(80,'press_releases','owner_id','Owner','User(username)',''),(81,'chunk','id','','id','hidden'),(84,'chunk','type','DBColumn Type','text',''),(87,'chunk','role','Role','text',''),(88,'chunk','name','Name','text',''),(89,'chunk_relation','id','','id','hidden'),(90,'chunk','parent_class','Parent Class','text',''),(91,'chunk','parent','Parent ID','integer',''),(92,'chunk_relation','chunk_id','Chunk','Chunk',''),(93,'chunk','chunk_revision_id','Chunk Revision','ChunkRevision',''),(94,'chunk_revision','id','','id','hidden'),(95,'chunk_revision','chunk_id','Chunk','Chunk',''),(96,'chunk_revision','content','Content','text',''),(97,'chunk_revision','timestamp','Timestamp','timestamp',''),(98,'chunk_relation','sort','Sort Order','sort','');
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
  `chunk_revision_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk`
--

LOCK TABLES `chunk` WRITE;
/*!40000 ALTER TABLE `chunk` DISABLE KEYS */;
INSERT INTO `chunk` VALUES (1,'text',NULL,NULL,'ContentPageRevision',16,11),(2,'tinymce',NULL,NULL,'ContentPageRevision',16,12),(3,'date',NULL,NULL,'ContentPageRevision',16,13);
/*!40000 ALTER TABLE `chunk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chunk_revision`
--

DROP TABLE IF EXISTS `chunk_revision`;
CREATE TABLE `chunk_revision` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `chunk_id` int(10) unsigned default NULL,
  `content` varchar(256) default NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chunk_revision`
--

LOCK TABLES `chunk_revision` WRITE;
/*!40000 ALTER TABLE `chunk_revision` DISABLE KEYS */;
INSERT INTO `chunk_revision` VALUES (11,1,'Chunk 1','2009-01-10 10:09:08'),(12,2,'Chunk 2','2009-01-10 10:09:08'),(13,3,'2009-01-09 21:09:58','2009-01-10 10:09:38');
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

-- Dump completed on 2009-01-10 13:07:41
